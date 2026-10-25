<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Default Auth Users (Admin and Student)
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'name' => 'Admin Instructor',
                'email' => 'admin@genzdigital.edu',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'student_id' => null,
                'major' => 'Faculty Administration',
                'gender' => 'Male',
                'avatar' => null,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maya Chen',
                'email' => 'maya.chen@genzdigital.edu',
                'password' => bcrypt('password'),
                'role' => 'student',
                'student_id' => 'GZ20260482',
                'major' => 'Visual Communication',
                'gender' => 'Female',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 1. Students / Users
        DB::table('campus_students')->truncate();
        DB::table('campus_students')->insert([
            [
                'name' => 'Maya Chen',
                'student_id' => 'GZ20260482',
                'email' => 'maya.chen@genzdigital.edu',
                'major' => 'Visual Communication',
                'gender' => 'Female',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
                'status' => 'Active',
                'attendance_rate' => '92%',
                'valid_until' => '08/2028',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Liam Sokha',
                'student_id' => 'GZ20260495',
                'email' => 'liam.sokha@genzdigital.edu',
                'major' => 'Software Engineering',
                'gender' => 'Male',
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=250',
                'status' => 'Active',
                'attendance_rate' => '88%',
                'valid_until' => '08/2028',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sophia Vathanak',
                'student_id' => 'GZ20260512',
                'email' => 'sophia.v@genzdigital.edu',
                'major' => 'UI/UX Design',
                'gender' => 'Female',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=250',
                'status' => 'Active',
                'attendance_rate' => '96%',
                'valid_until' => '08/2028',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Meng',
                'student_id' => 'GZ20260528',
                'email' => 'david.meng@genzdigital.edu',
                'major' => 'Data Science & AI',
                'gender' => 'Male',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=250',
                'status' => 'Inactive',
                'attendance_rate' => '74%',
                'valid_until' => '08/2028',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emily Rath',
                'student_id' => 'GZ20260534',
                'email' => 'emily.rath@genzdigital.edu',
                'major' => 'Interactive Media',
                'gender' => 'Female',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=250',
                'status' => 'Active',
                'attendance_rate' => '95%',
                'valid_until' => '08/2028',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. Classes
        DB::table('campus_classes')->truncate();
        DB::table('campus_classes')->insert([
            [
                'title' => 'UI/UX Design Systems',
                'code' => 'DES302',
                'room' => 'Lab 402 • Media Wing',
                'prof' => 'Dr. Alex Vance',
                'schedule_time' => '08:00 AM - 10:30 AM',
                'status' => 'Ongoing',
                'type' => 'Lecture & Lab',
                'border_color' => '#3b82f6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Brand Identity Strategy',
                'code' => 'MKT204',
                'room' => 'Hall B • Innovation Hub',
                'prof' => 'Prof. Sarah Lin',
                'schedule_time' => '11:00 AM - 01:00 PM',
                'status' => 'Upcoming',
                'type' => 'Workshop',
                'border_color' => '#6366f1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Motion Design in After Effects',
                'code' => 'DES305',
                'room' => 'Studio 12 • Arts Bldg',
                'prof' => 'Marcello Rossi',
                'schedule_time' => '02:00 PM - 04:30 PM',
                'status' => 'Upcoming',
                'type' => 'Studio Class',
                'border_color' => '#8b5cf6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Attendances
        DB::table('campus_attendances')->truncate();
        DB::table('campus_attendances')->insert([
            [
                'student_name' => 'Maya Chen',
                'student_id' => 'GZ20260482',
                'subject' => 'UI/UX Design Systems',
                'code' => 'DES302',
                'status' => 'Present',
                'check_in_time' => 'Today, 08:05 AM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_name' => 'Liam Sokha',
                'student_id' => 'GZ20260495',
                'subject' => 'UI/UX Design Systems',
                'code' => 'DES302',
                'status' => 'Present',
                'check_in_time' => 'Today, 08:10 AM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_name' => 'Sophia Vathanak',
                'student_id' => 'GZ20260512',
                'subject' => 'UI/UX Design Systems',
                'code' => 'DES302',
                'status' => 'Late',
                'check_in_time' => 'Today, 08:25 AM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_name' => 'David Meng',
                'student_id' => 'GZ20260528',
                'subject' => 'UI/UX Design Systems',
                'code' => 'DES302',
                'status' => 'Absent',
                'check_in_time' => '--',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Exams
        DB::table('campus_exams')->truncate();
        DB::table('campus_exams')->insert([
            [
                'title' => 'UI/UX Design Systems',
                'course' => 'DES302',
                'exam_date' => 'Nov 12, 2026 • 09:00 AM',
                'room' => 'Room 402',
                'type' => 'Mid-Term Exam',
                'status' => 'Scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Brand Identity Strategy',
                'course' => 'MKT204',
                'exam_date' => 'Nov 20, 2026 • 02:00 PM',
                'room' => 'Innovation Hall B',
                'type' => 'Final Presentation',
                'status' => 'Scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 5. Challenges
        DB::table('campus_challenges')->truncate();
        DB::table('campus_challenges')->insert([
            [
                'title' => 'Design 3 Micro-interactions',
                'description' => 'Build high-fidelity prototypes of 3 micro-interactions using Figma or Principle.',
                'points' => 500,
                'deadline' => 'Friday, 11:59 PM',
                'status' => 'Active',
                'badge' => 'NEW',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Full Page Responsive UI Audit',
                'description' => 'Perform usability and heuristic evaluation of an e-commerce checkout flow.',
                'points' => 350,
                'deadline' => 'Nov 05, 2026',
                'status' => 'Active',
                'badge' => 'HOT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 6. Certificates
        DB::table('campus_certificates')->truncate();
        DB::table('campus_certificates')->insert([
            [
                'title' => 'UX Master Certificate',
                'recipient' => 'Maya Chen',
                'issue_date' => 'Oct 2026',
                'credential_id' => 'GZ-UX-2026-8812',
                'status' => 'Verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Design Thinking Honors',
                'recipient' => 'Maya Chen',
                'issue_date' => 'Aug 2026',
                'credential_id' => 'GZ-DT-2026-4019',
                'status' => 'Verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 7. Resources
        DB::table('campus_resources')->truncate();
        DB::table('campus_resources')->insert([
            [
                'title' => 'Lecture 04 - Component Design Systems',
                'course' => 'DES302',
                'file_name' => 'DES302_Lecture_04.pdf',
                'file_size' => '8.4 MB',
                'download_count' => 142,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Design System Toolkit (Figma)',
                'course' => 'DES302',
                'file_name' => 'Design_System_Toolkit.fig',
                'file_size' => '24.1 MB',
                'download_count' => 328,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Brand Guidelines Case Study',
                'course' => 'MKT204',
                'file_name' => 'Brand_Strategy_Guide.pdf',
                'file_size' => '12.6 MB',
                'download_count' => 95,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 8. Collaborations
        DB::table('campus_collaborations')->truncate();
        DB::table('campus_collaborations')->insert([
            [
                'title' => 'Hackathon Team (3/4)',
                'description' => 'Building an AI campus navigation assistant for students.',
                'required_role' => '1 UI/UX Designer',
                'current_members' => 3,
                'max_members' => 4,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'VR Campus Tour Project',
                'description' => '3D virtual tour experience for new university admissions.',
                'required_role' => '3D Motion Designer',
                'current_members' => 2,
                'max_members' => 5,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 9. QR Codes
        DB::table('campus_qr_codes')->truncate();
        DB::table('campus_qr_codes')->insert([
            [
                'title' => 'Lab 402 Morning Check-in',
                'type' => 'Attendance',
                'code_value' => 'GZ-QR-ATT-LAB402-20261024',
                'expires_at' => '11:00 AM Today',
                'scans_count' => 48,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Main Campus Gate Access Pass',
                'type' => 'Security Gate',
                'code_value' => 'GZ-GATE-ENTRY-0091',
                'expires_at' => 'Daily 11:59 PM',
                'scans_count' => 340,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Library Loan Fast-Pass',
                'type' => 'Library Loan',
                'code_value' => 'GZ-LIB-FASTPASS-821',
                'expires_at' => 'Weekly',
                'scans_count' => 112,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 10. Teaching Slides
        DB::table('campus_teaching_slides')->truncate();
        DB::table('campus_teaching_slides')->insert([
            [
                'title' => 'Design Tokens & Component Hierarchy',
                'course' => 'UI/UX Design Systems (DES302)',
                'current_slide' => 1,
                'total_slides' => 6,
                'slide_notes' => 'Discuss how atomic tokens propagate through complex components in Figma and code.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 11. Screen Broadcast
        DB::table('campus_screen_broadcasts')->truncate();
        DB::table('campus_screen_broadcasts')->insert([
            [
                'student_name' => 'Maya Chen',
                'student_id' => 'GZ20260482',
                'room' => 'Lab 402 • Media Wing',
                'is_broadcasting' => true,
                'preview_title' => 'Figma Prototype: GenZ Mobile Campus App',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 12. Student Scores (Maya Chen - Visual Communication)
        DB::table('campus_scores')->truncate();
        DB::table('campus_scores')->insert([
            [
                'student_id' => 'GZ20260482',
                'student_name' => 'Maya Chen',
                'subject' => 'UI/UX Design Systems',
                'code' => 'DES302',
                'credits' => 3,
                'score' => 95.5,
                'grade' => 'A+',
                'mid_term' => 38,
                'assignment' => 20,
                'final_exam' => 37.5,
                'semester' => 'Semester 1 - 2026',
                'status' => 'Passed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'student_name' => 'Maya Chen',
                'subject' => 'Motion Design in After Effects',
                'code' => 'DES305',
                'credits' => 4,
                'score' => 92.0,
                'grade' => 'A',
                'mid_term' => 36,
                'assignment' => 19,
                'final_exam' => 37.0,
                'semester' => 'Semester 1 - 2026',
                'status' => 'Passed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'student_name' => 'Maya Chen',
                'subject' => 'Design Thinking & Research',
                'code' => 'RES201',
                'credits' => 3,
                'score' => 98.0,
                'grade' => 'A+',
                'mid_term' => 39,
                'assignment' => 20,
                'final_exam' => 39.0,
                'semester' => 'Semester 1 - 2026',
                'status' => 'Passed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'student_name' => 'Maya Chen',
                'subject' => 'Brand Identity Strategy',
                'code' => 'MKT204',
                'credits' => 3,
                'score' => 88.5,
                'grade' => 'B+',
                'mid_term' => 34,
                'assignment' => 18.5,
                'final_exam' => 36.0,
                'semester' => 'Semester 1 - 2026',
                'status' => 'Passed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'student_name' => 'Maya Chen',
                'subject' => 'Typography & Layout Fundamentals',
                'code' => 'ART102',
                'credits' => 3,
                'score' => 91.0,
                'grade' => 'A',
                'mid_term' => 36,
                'assignment' => 19,
                'final_exam' => 36.0,
                'semester' => 'Semester 1 - 2026',
                'status' => 'Passed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 13. Class Cart / Enrolled Classes & Course Cart
        DB::table('campus_course_carts')->truncate();
        DB::table('campus_course_carts')->insert([
            [
                'student_id' => 'GZ20260482',
                'course_title' => 'UI/UX Design Systems',
                'course_code' => 'DES302',
                'credits' => 3,
                'instructor' => 'Dr. Alex Vance',
                'schedule' => 'Mon, Wed 08:00 AM',
                'status' => 'Enrolled',
                'fee' => 'Paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'course_title' => 'Motion Design in After Effects',
                'course_code' => 'DES305',
                'credits' => 4,
                'instructor' => 'Marcello Rossi',
                'schedule' => 'Tue, Thu 02:00 PM',
                'status' => 'Enrolled',
                'fee' => 'Paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'course_title' => 'Brand Identity Strategy',
                'course_code' => 'MKT204',
                'credits' => 3,
                'instructor' => 'Prof. Sarah Lin',
                'schedule' => 'Fri 11:00 AM',
                'status' => 'Enrolled',
                'fee' => 'Paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'course_title' => 'Generative AI for 3D Art (Elective)',
                'course_code' => 'AI401',
                'credits' => 3,
                'instructor' => 'Dr. Jennifer Wu',
                'schedule' => 'Sat 09:00 AM',
                'status' => 'In Cart',
                'fee' => '$120 / Credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 'GZ20260482',
                'course_title' => 'Interactive Sound Design (Elective)',
                'course_code' => 'MUS205',
                'credits' => 3,
                'instructor' => 'Prof. Eric Thorne',
                'schedule' => 'Sat 01:30 PM',
                'status' => 'In Cart',
                'fee' => '$120 / Credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
