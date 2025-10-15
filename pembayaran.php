<?php
require_once 'config/config.php';
requireLogin();

$db = new Database();
$conn = $db->getConnection();

// Get jenis pajak
$stmt = $conn->prepare("SELECT * FROM jenis_pajak WHERE status = 'active' ORDER BY nama_pajak");
$stmt->execute();
$jenisPajak = $stmt->fetchAll();

// Get all users if admin (for admin to select other users)
$users = [];
if (isAdmin()) {
    $stmt = $conn->prepare("SELECT id, full_name, npwp, email FROM users WHERE status = 'active' ORDER BY full_name");
    $stmt->execute();
    $users = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pajak - KTT Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 800px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
            margin-top: 20px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .info-box {
            background: #dbeafe;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <div class="page-header">
                <h1 data-i18n="payment.title">Pembayaran Pajak</h1>
                <p data-i18n="payment.subtitle">Lakukan pembayaran pajak Anda dengan mudah dan aman</p>
            </div>

            <div class="form-card">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <strong><span data-i18n="payment.info">Informasi</span>:</strong> <span data-i18n="payment.info_text">Pastikan semua data yang Anda masukkan sudah benar. Pembayaran yang sudah diproses tidak dapat dibatalkan.</span>
                </div>

                <div id="alert" class="alert"></div>

                <form id="paymentForm" method="POST">
                    <h3 style="margin-bottom: 20px; color: #059669;">
                        <i class="fas fa-file-invoice"></i>
                        <span data-i18n="payment.tax_data">Data Pajak</span>
                    </h3>

                    <?php if (isAdmin()): ?>
                    <!-- Admin can select user or input manual NPWP -->
                    <div class="form-group">
                        <label for="payment_for"><span data-i18n="payment.for_user">Pembayaran untuk</span> <span class="required">*</span></label>
                        <select class="form-control" id="payment_for" name="payment_for" required>
                            <option value="self" data-i18n="payment.personal_payment" data-fullname="<?php echo htmlspecialchars($_SESSION['full_name']); ?>">Pembayaran Pribadi (<?php echo $_SESSION['full_name']; ?>)</option>
                            <option value="other_user" data-i18n="payment.select_user">Pilih Pengguna Lain</option>
                            <option value="manual" data-i18n="payment.manual_npwp">Input NPWP Manual</option>
                        </select>
                    </div>

                    <!-- Dropdown for selecting other users (hidden by default) -->
                    <div class="form-group" id="user_select_wrapper" style="display: none;">
                        <label for="selected_user_id"><span data-i18n="payment.choose_user">Pilih Pengguna</span> <span class="required">*</span></label>
                        <select class="form-control" id="selected_user_id" name="selected_user_id">
                            <option value="">-- Pilih Pengguna --</option>
                            <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" 
                                    data-npwp="<?php echo htmlspecialchars($user['npwp']); ?>"
                                    data-name="<?php echo htmlspecialchars($user['full_name']); ?>">
                                <?php echo htmlspecialchars($user['full_name']); ?> - <?php echo htmlspecialchars($user['npwp']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="jenis_pajak_id"><span data-i18n="payment.select_tax">Jenis Pajak</span> <span class="required">*</span></label>
                        <select class="form-control" id="jenis_pajak_id" name="jenis_pajak_id" required>
                            <option value="" data-i18n="payment.choose_tax">Pilih Jenis Pajak</option>
                            <?php foreach ($jenisPajak as $jp): 
                                // Convert tax code to translation key format
                                $code = $jp['kode_pajak'];
                                $taxCode = strtolower($code);
                                if (preg_match('/^(pph)(\d+)$/i', $taxCode, $matches)) {
                                    $taxCode = strtolower($matches[1]) . '_' . $matches[2];
                                }
                            ?>
                            <option value="<?php echo $jp['id']; ?>" 
                                    data-persentase="<?php echo $jp['persentase']; ?>"
                                    data-tax-code="<?php echo $jp['kode_pajak']; ?>"
                                    data-i18n="tax.<?php echo $taxCode; ?>_name">
                                <?php echo $jp['kode_pajak']; ?> - <?php echo $jp['nama_pajak']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="npwp">NPWP <span class="required">*</span></label>
                            <input type="text" class="form-control" id="npwp" name="npwp" 
                                   value="<?php echo $_SESSION['npwp']; ?>" 
                                   <?php echo !isAdmin() ? 'readonly' : ''; ?> 
                                   required 
                                   placeholder="<?php echo isAdmin() ? 'NPWP akan terisi otomatis atau input manual' : ''; ?>" 
                                   data-i18n-placeholder="payment.npwp_placeholder">
                        </div>

                        <div class="form-group">
                            <label for="tahun_pajak"><span data-i18n="payment.tax_year">Tahun Pajak</span> <span class="required">*</span></label>
                            <select class="form-control" id="tahun_pajak" name="tahun_pajak" required>
                                <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="masa_pajak"><span data-i18n="payment.tax_period">Masa Pajak</span> <span class="required">*</span></label>
                        <select class="form-control" id="masa_pajak" name="masa_pajak" required>
                            <option value="" data-i18n="payment.choose_period">Pilih Masa Pajak</option>
                            <option value="Januari" data-i18n="month.january">Januari</option>
                            <option value="Februari" data-i18n="month.february">Februari</option>
                            <option value="Maret" data-i18n="month.march">Maret</option>
                            <option value="April" data-i18n="month.april">April</option>
                            <option value="Mei" data-i18n="month.may">Mei</option>
                            <option value="Juni" data-i18n="month.june">Juni</option>
                            <option value="Juli" data-i18n="month.july">Juli</option>
                            <option value="Agustus" data-i18n="month.august">Agustus</option>
                            <option value="September" data-i18n="month.september">September</option>
                            <option value="Oktober" data-i18n="month.october">Oktober</option>
                            <option value="November" data-i18n="month.november">November</option>
                            <option value="Desember" data-i18n="month.december">Desember</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="jumlah_pajak"><span data-i18n="payment.tax_amount_label">Jumlah Pajak (Rp)</span> <span class="required">*</span></label>
                            <input type="number" class="form-control" id="jumlah_pajak" name="jumlah_pajak" min="0" step="1000" required>
                        </div>

                        <div class="form-group">
                            <label for="denda"><span data-i18n="payment.penalty">Denda (Rp)</span></label>
                            <input type="number" class="form-control" id="denda" name="denda" value="0" min="0" step="1000">
                        </div>
                    </div>

                    <h3 style="margin: 30px 0 20px; color: #059669;">
                        <i class="fas fa-credit-card"></i> <span data-i18n="payment.payment_method_title">Metode Pembayaran</span>
                    </h3>

                    <div class="form-group">
                        <label for="metode_pembayaran"><span data-i18n="payment.choose_method">Pilih Metode Pembayaran</span> <span class="required">*</span></label>
                        <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="" data-i18n="payment.select_method">Pilih Metode</option>
                            <option value="transfer_bank" data-i18n="payment.bank_transfer">Transfer Bank</option>
                            <option value="virtual_account" data-i18n="payment.virtual_account">Virtual Account</option>
                            <option value="e_wallet" data-i18n="payment.ewallet_detail">E-Wallet (OVO, GoPay, Dana)</option>
                            <option value="kartu_kredit" data-i18n="payment.credit_card">Kartu Kredit</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="keterangan"><span data-i18n="payment.notes_label">Keterangan (Opsional)</span></label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="" data-i18n-placeholder="payment.notes_placeholder"></textarea>
                    </div>

                    <div class="form-group" style="background: #f9fafb; padding: 15px; border-radius: 8px;">
                        <h4 style="margin-bottom: 10px;" data-i18n="payment.total_payment">Total Pembayaran:</h4>
                        <h2 id="total_display" style="color: #059669;">Rp 0</h2>
                        <input type="hidden" id="total_bayar" name="total_bayar" value="0">
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> <span data-i18n="payment.process_payment">Proses Pembayaran</span>
                    </button>
                </form>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
        // Auto-select jenis pajak from URL parameter
        window.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const taxId = urlParams.get('tax_id');
            
            if (taxId) {
                const jenisPajakSelect = document.getElementById('jenis_pajak_id');
                if (jenisPajakSelect) {
                    jenisPajakSelect.value = taxId;
                    
                    // Trigger change event if needed for any dependent logic
                    const event = new Event('change');
                    jenisPajakSelect.dispatchEvent(event);
                }
            }
        });

        // Admin payment for selection handler
        <?php if (isAdmin()): ?>
        const paymentForSelect = document.getElementById('payment_for');
        const userSelectWrapper = document.getElementById('user_select_wrapper');
        const selectedUserIdSelect = document.getElementById('selected_user_id');
        const npwpInput = document.getElementById('npwp');
        const originalNpwp = '<?php echo $_SESSION['npwp']; ?>';

        if (paymentForSelect) {
            paymentForSelect.addEventListener('change', function() {
                const value = this.value;
                
                if (value === 'self') {
                    // Self payment - use own NPWP
                    userSelectWrapper.style.display = 'none';
                    selectedUserIdSelect.required = false;
                    npwpInput.value = originalNpwp;
                    npwpInput.readOnly = true;
                } else if (value === 'other_user') {
                    // Select other user
                    userSelectWrapper.style.display = 'block';
                    selectedUserIdSelect.required = true;
                    npwpInput.value = '';
                    npwpInput.readOnly = true;
                } else if (value === 'manual') {
                    // Manual NPWP input
                    userSelectWrapper.style.display = 'none';
                    selectedUserIdSelect.required = false;
                    npwpInput.value = '';
                    npwpInput.readOnly = false;
                    npwpInput.focus();
                }
            });

            // Handle user selection
            selectedUserIdSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const npwp = selectedOption.getAttribute('data-npwp');
                    npwpInput.value = npwp;
                } else {
                    npwpInput.value = '';
                }
            });
        }
        <?php endif; ?>

        // Calculate total
        function calculateTotal() {
            const jumlahPajak = parseFloat(document.getElementById('jumlah_pajak').value) || 0;
            const denda = parseFloat(document.getElementById('denda').value) || 0;
            const total = jumlahPajak + denda;
            
            document.getElementById('total_display').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total_bayar').value = total;
        }

        document.getElementById('jumlah_pajak').addEventListener('input', calculateTotal);
        document.getElementById('denda').addEventListener('input', calculateTotal);

        // Handle translation for personal payment option with dynamic name
        function updatePersonalPaymentOption() {
            const personalOption = document.querySelector('option[value="self"]');
            if (personalOption) {
                const fullName = personalOption.getAttribute('data-fullname');
                const translationKey = personalOption.getAttribute('data-i18n');
                if (translationKey && window.i18n) {
                    const translatedText = window.i18n.t(translationKey);
                    personalOption.textContent = `${translatedText} (${fullName})`;
                }
            }
        }

        // Handle translation for tax type dropdown options
        function updateTaxTypeOptions() {
            const taxSelect = document.getElementById('jenis_pajak_id');
            if (taxSelect) {
                const options = taxSelect.querySelectorAll('option[data-tax-code]');
                options.forEach(option => {
                    const taxCode = option.getAttribute('data-tax-code');
                    const translationKey = option.getAttribute('data-i18n');
                    if (translationKey && window.i18n) {
                        const translatedName = window.i18n.t(translationKey);
                        option.textContent = `${taxCode} - ${translatedName}`;
                    }
                });
            }
        }

        // Update on language change
        document.addEventListener('languageChanged', function() {
            updatePersonalPaymentOption();
            updateTaxTypeOptions();
        });
        
        // Initial update
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                updatePersonalPaymentOption();
                updateTaxTypeOptions();
            });
        } else {
            updatePersonalPaymentOption();
            updateTaxTypeOptions();
        }

        // Submit form
        document.getElementById('paymentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const alertDiv = document.getElementById('alert');
            
            try {
                const response = await fetch('process_payment.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alertDiv.className = 'alert alert-success';
                    alertDiv.style.display = 'block';
                    alertDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + result.message;
                    
                    setTimeout(() => {
                        window.location.href = 'riwayat.php';
                    }, 2000);
                } else {
                    alertDiv.className = 'alert alert-error';
                    alertDiv.style.display = 'block';
                    alertDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + result.message;
                }
            } catch (error) {
                alertDiv.className = 'alert alert-error';
                alertDiv.style.display = 'block';
                alertDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan. Silakan coba lagi.';
            }
        });
    </script>
</body>
</html>
