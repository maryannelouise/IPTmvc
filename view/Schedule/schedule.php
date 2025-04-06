<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: linear-gradient(#A294F9, #CDC1FF, #E5D9F2, #F5EFFF);
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Raleway', sans-serif;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
        }

        .container {
            max-width: 950px;
            margin: 60px auto;
        }

        .form-card {
            background-color: #fff;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #5b5ea6;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary {
            background-color: #5B5EA6;
            border-color: #5B5EA6;
        }

        .btn-primary:hover {
            background-color: #4a4e8f;
        }

        .btn-danger {
            background-color: #f76c6c;
            border-color: #f76c6c;
        }

        .btn-danger:hover {
            background-color: #e05656;
        }

        .table th {
            background-color: #f4f4f9;
        }

        .add-btn {
            margin-bottom: 15px;
        }

        .form-section {
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <!-- Enhanced Form -->
    <div class="container">
        <div class="form-card">
            <?php
            require_once __DIR__ . '/../../model/DoctorModel.php';
            $doctorModel = new DoctorModel();

            // Check if doctor_id is passed
            if (isset($_GET['doctor_id'])) {
                $doctor = $doctorModel->getDoctorById($_GET['doctor_id']);
                echo '<h2><i class="fas fa-calendar-check me-2"></i>Schedule with ' . htmlspecialchars($doctor['name']) . '</h2>';
                $selectedDoctorId = $doctor['id'];
            } else {
                $doctors = $doctorModel->getAllDoctors();
                echo '<h2><i class="fas fa-calendar-check me-2"></i>Schedule Your Appointment</h2>';
                $selectedDoctorId = null;
            }
            ?>

            <form id="appointmentForm" action="/careset/view/Doctors/book.php" method="POST"
                enctype="multipart/form-data">
                <div id="formErrors" class="alert alert-danger d-none"></div>

                <!-- Doctor Selection (only shown when not pre-selected) -->
                <?php if (!isset($_GET['doctor_id'])): ?>
                    <div class="form-section">
                        <label for="doctor_id" class="form-label">Select Doctor</label>
                        <select class="form-select" id="doctor_id" name="doctor_id" required>
                            <option value="" disabled selected>Select a Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= htmlspecialchars($doctor['id']) ?>"><?= htmlspecialchars($doctor['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <!-- Hidden doctor_id input when doctor is pre-selected -->
                    <input type="hidden" id="doctor_id" name="doctor_id" value="<?= htmlspecialchars($selectedDoctorId) ?>">
                <?php endif; ?>

                <!-- Name Fields -->
                <div class="row form-section">
                    <div class="col-md-6 mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                </div>

                <!-- Gender & Birthdate -->
                <div class="row form-section">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                    </div>
                </div>

                <!-- Medical Records -->
                <div class="form-section">
                    <label class="form-label">Upload Medical Records</label>
                    <button type="button" class="btn btn-sm btn-outline-primary add-btn" onclick="addMedicalRecord()">
                        <i class="fas fa-plus"></i> Add More
                    </button>
                    <div id="medicalRecordsContainer">
                        <div class="row mb-2 medical-record-entry">
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="medical_records[]" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="file_description[]"
                                    placeholder="File Description" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-danger"
                                    onclick="removeMedicalRecord(this)">×</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disease Table -->
                <div class="form-section">
                    <label class="form-label">Known Diseases</label>
                    <table class="table" id="diseaseTable">
                        <thead>
                            <tr>
                                <th>Disease <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="addRow()">
                                        <i class="fas fa-plus"></i> Add
                                    </button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="disease[]" required></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Appointment Date -->
                <div class="form-section">
                    <label for="appointment_date" class="form-label">Select Appointment Date</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required
                        min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+3 months')) ?>">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="fas fa-calendar-check me-2"></i> Confirm Appointment
                    </button>
                </div>
            </form>

            <script>
                document.getElementById('appointmentForm').addEventListener('submit', async function (e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);
                    const errorContainer = document.getElementById('formErrors');
                    const submitButton = form.querySelector('button[type="submit"]');

                    // Reset UI
                    errorContainer.classList.add('d-none');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData
                        });

                        // Handle empty response
                        if (response.status === 500 && response.headers.get('content-length') === '0') {
                            throw new Error('Server error: Please try again later');
                        }

                        const text = await response.text();

                        // Update the page with the response text (HTML content)
                        document.body.innerHTML = text;

                    } catch (error) {
                        errorContainer.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>${error.message}</div>
                            </div>
                        `;
                        errorContainer.classList.remove('d-none');
                        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        console.error('Submission error:', error);

                    } finally {
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Confirm Appointment';
                    }
                });

                function addRow() {
                    const table = document.getElementById('diseaseTable').getElementsByTagName('tbody')[0];
                    const row = table.insertRow(table.rows.length);
                    row.innerHTML = `
                        <td><input type="text" class="form-control" name="disease[]" required></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </td>
                    `;
                }

                function removeRow(button) {
                    const row = button.closest('tr');
                    row.remove();
                }

                function addMedicalRecord() {
                    const container = document.getElementById('medicalRecordsContainer');
                    const entry = document.createElement('div');
                    entry.classList.add('row', 'mb-2', 'medical-record-entry');
                    entry.innerHTML = `
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="medical_records[]" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="file_description[]" placeholder="File Description" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-danger" onclick="removeMedicalRecord(this)">×</button>
                        </div>
                    `;
                    container.appendChild(entry);
                }

                function removeMedicalRecord(button) {
                    const entry = button.closest('.medical-record-entry');
                    entry.remove();
                }
            </script>
        </div>
    </div>
</body>

</html>
