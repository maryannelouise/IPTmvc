<?php
require_once __DIR__ . '/../controller/AppointmentController.php';

return [
    '/' => ['HomeController', 'index'],
    '/homepage' => ['HomeController', 'homepage'],
    
    // User routes
    '/login' => ['UserController', 'login'],
    '/register' => ['UserController', 'register'],
    '/logout' => ['UserController', 'logout'],
    '/changePicture' => ['UserController', 'changePicture'],
    
    // Appointment routes
    '/schedule' => ['App\Controller\AppointmentController', 'showScheduleForm'],
    '/schedule/submit' => ['App\Controller\AppointmentController', 'create'],
    '/appointments' => ['App\Controller\AppointmentController', 'create'], // This matches for creating an appointment via /appointments
    '/appointments/doctor/(\d+)' => ['App\Controller\AppointmentController', 'getByDoctor'], // Get appointments for a specific doctor
    '/appointments/(\d+)' => ['App\Controller\AppointmentController', 'get'], // Get specific appointment details
    '/appointments/update/(\d+)' => ['App\Controller\AppointmentController', 'update'], // Update appointment
    '/appointments/cancel/(\d+)' => ['App\Controller\AppointmentController', 'cancel'], // Cancel appointment

    // Doctor routes
    '/doctors' => ['DoctorController', 'index'],
    '/doctors/specialty/(\d+)' => ['DoctorController', 'showDoctors'],
    '/doctors/schedule/(\d+)' => ['DoctorController', 'showSchedule'],
    '/doctors/book' => ['DoctorController', 'bookAppointment'],
    '/doctors/success' => ['DoctorController', 'showSuccess'],
    '/success' => ['DoctorController', 'showSuccess'],

    // API routes
    '/api/users' => ['ApiController', 'users'],
    '/api/login' => ['ApiController', 'login'],
    
    // API appointment routes (RESTful style)
    '/api/appointments' => ['App\Controller\AppointmentController', 'handleApiRequest'],
    '/api/appointments/(\d+)' => ['App\Controller\AppointmentController', 'handleApiRequest']
];
