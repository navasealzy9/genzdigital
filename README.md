# GenZ Digital — E-Learning

Laravel 12 / PHP 8.2+ learning platform with separate administrator and student workspaces. Uses the configured MySQL or SQLite database. The new responsive interface uses local CSS and works without a Node build or external UI CDN.

## Learning workflow

1. Administrator creates a **draft course** with a code, description, and instructor.
2. Add lessons grouped into chapters, plain-text lesson content, optional HTTPS video links, and private downloadable materials. Publish the lessons that are ready.
3. Optionally add assignments and quizzes. Set passing scores, deadlines, time limits, and attempt limits. Add actual multiple-choice questions before publishing a quiz.
4. Publish the course after at least one lesson is published.
5. Enroll student accounts through the course management page, or enable self-enrollment. Suspension blocks access while retaining learning history.
6. Students study lessons, confirm completion, submit assignments, and take quizzes.
7. Administrator grades assignments and provides feedback. Quizzes are graded on the server using weighted question points.
8. Progress counts completed published lessons, passed published assignments, and passed published quizzes equally. Students receive a printable completion certificate only when **all** requirements are met and at least one lesson exists.

Lesson completion is student-confirmed; it does not claim verified video watch time. No GPA, attendance, grades, payment status, or learning progress is fabricated.

## Administrator

Open `/admin` using an active administrator account.

The sidebar separates Overview, Courses, Students, and Create course. Overview highlights real totals, recent courses, pending assignment reviews, and publishing status. Course and student lists support search and status filters; results are paginated (8 courses or 12 students per page). On phones, the sidebar becomes a compact navigation row and the recent course table becomes a stacked list.

- Create/edit courses; use draft, published, or archived status. Archived courses are hidden from students and retain their history.
- Add/edit/order lessons and chapters. Unpublish a lesson to remove it from current course requirements. Course material uploads support PDF, TXT, DOC/DOCX, PPT/PPTX, ZIP up to 20 MB.
- Create student accounts or let students register. Activate/deactivate accounts.
- Assign or suspend enrollment for each course and student.
- Create assignments, review private submissions, download attachments, and grade with feedback. Assignment requirements lock after the first submission. To allow revision, reopen a submission and set a new assignment deadline; this extends the deadline for all students and clears that submission's grade while retaining its answer and feedback.
- Create draft quizzes, add/remove questions, and publish them. Assessments lock after their first attempt to preserve grading consistency. The attempt limit can still be increased up to 10 for all students. To change assessment content or its schedule after attempts exist, create a new quiz.
- View individual progress and quiz results; export course progress as CSV.

## Student

Open `/` using an active student account.

- View published courses and enrolled courses. Courses can require administrator enrollment or allow direct enrollment; suspended enrollment cannot be bypassed by self-enrolling again.
- Study published lessons and download private materials.
- Submit text and optional PDF/TXT/DOC/DOCX/ZIP/PNG/JPG attachments up to 20 MB. Ungraded work can be updated before its deadline. Graded work requires reopening by the administrator.
- Start or resume timed quizzes. Selecting an answer saves it to the server; the UI reports save failures. Leaving the page does not pause the server deadline. Late requests cannot add answers: expired attempts are graded from answers saved before expiry. A quiz can have opening/closing dates and a maximum attempt count.
- View only personal submissions, feedback, results, progress, and certificates. Certificate printing supports the browser's Save as PDF option.

## GEN5 — live two-team city building

Open **GEN5** in the administrator sidebar to create a match for a class (course). Set a title, two team names, and a countdown of 1–60 minutes. Only one lobby/running match is allowed per class. Students find GEN5 in their navigation or dashboard and can only enter matches for classes where they have active enrollment. GEN5 can be opened for a draft course independently of publishing learning content; archived classes are unavailable.

1. Students join the lobby and are automatically assigned to the smaller team. Up to 40 players can join each team. Administrators can adjust teams in the lobby. At least one active enrolled student on each team is required to start.
2. Click **Full screen** to open the projector in a new tab. The projector displays both territories, player movement, building counts, the countdown, and the final result. Use its Full screen button to request browser fullscreen. Start, finish early, or cancel from the main administration match tab.
3. Start the match when everyone is ready. Teams and new-player entry lock after start; existing players can refresh or reconnect to resume.
4. Students move with arrows/WASD, the on-screen directional pad, or by tapping the board. Select Move, Build, or Attack and tap a target: the character walks into range before performing one construction/attack action. **B** builds on the current tile; **X** attacks an adjacent enemy building. Touch buttons provide the same actions.
5. Build only in your own half. Three construction actions create a complete three-floor building, worth **one point**. Each attack removes one floor from an enemy building; damaged buildings stop scoring until repaired, and zero-floor buildings disappear. Players can freely cross the border but must be on or next to a target tile to build or attack.
6. At the server deadline, count complete buildings still standing. The team with more buildings wins; equal counts produce a draw. Final results are saved and cannot be changed by late actions. Cancelling does not declare a winner. Game results do not alter academic grades, lesson progress, or certificates.

All actions are authorized and serialized on a database match lock. The server enforces one-tile movement, territory, range, 220 ms movement cooldown, and 900 ms shared construction/attack cooldown; clients cannot submit their own scores, team identity, positions, or time extensions. The interface synchronizes through authenticated polling every **900 ms** in visible tabs (2.5 seconds in background tabs), with immediate state responses after actions and interpolation for movement. A WebSocket service or Node build is not required. Connection loss stops automatic movement; reopening reconnects to persisted state.

The existing Laravel scheduler also runs `php artisan gen5:finish-expired` every minute. State polling and incoming actions finalize expired matches immediately on access, so deadline enforcement does not depend on the scheduler. Match state, teams, recent events, and results are stored in the new `gen5_matches` and `gen5_players` tables without changing existing learning data.

## Existing installation and data

The `2026_10_27_000001_create_learning_platform` migration adds independent `learning_*` tables. It does **not** delete or reset the `users` or `campus_*` tables.

- Existing accounts and their administrator/student roles remain usable.
- Existing classroom records become **draft courses** for administrator review. Their instructor, code, and title are retained. Add real learning content before publishing.
- Existing enrolled course-cart rows are imported when their course code and student ID match a course and an existing student account. Rows without matching accounts remain in the legacy tables for review.
- Old attendance, scores, assignments, exams, resources, certificates, and other classroom data remain in `campus_*` tables. They are **not** used as new learning results or silently treated as completed work. The legacy code contains sample-data fallbacks, so these records need manual review before any future import.
- The old classroom controllers/views remain in the repository for reference, but their routes are no longer exposed. The active application uses `LearningController`, `LearningAdminController`, and `resources/views/learning`.
- Adding or unpublishing course requirements recalculates current completion eligibility. Previously issued certificate records are retained; students must meet the current requirements to retrieve a certificate through the course page.

For an existing installation:

```powershell
php artisan migrate
php artisan optimize:clear
php artisan learning:status
```

Review imported draft courses at `/admin`. There are no automatic demo lessons or default student scores.

## Fresh installation

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Configure `APP_URL`, database access, and `APP_TIMEZONE` in `.env`. The default timezone is `Asia/Phnom_Penh` (UTC+7). Point the web server's document root to `public`, or run:

```powershell
php artisan migrate
php artisan learning:admin admin@example.com
php artisan serve
```

`learning:admin` asks for a name and a password of at least 12 characters without displaying the password. It creates a new administrator and refuses to modify an existing account. There is no built-in administrator password. Public registration always creates students with passwords of at least 8 characters.

Legacy migrations contain sample classroom records; the new application does not expose those records as learning progress. The legacy `CampusSeeder` is not needed for the learning platform.

## Assessment expiration

For regular background expiration, run Laravel's scheduler:

```powershell
php artisan schedule:work
```

For production use a scheduled task that runs `php artisan schedule:run` every minute. `learning:expire-attempts` can also be run manually. Expired attempts are additionally finalized when students open their dashboard/course and administrators open course management, so they cannot extend assessment time if the scheduler is unavailable.

## Verification

```powershell
php artisan test
php artisan route:list --except-vendor
php artisan view:cache
php artisan learning:status
```

The feature suite uses forced in-memory SQLite with `RefreshDatabase`, never the configured live database. It covers authorization, registration, inactive accounts, course publishing, enrollment, private files, deadlines, grading, saved timed answers, attempt limits, student isolation, and certificate eligibility. The previous legacy tests were replaced because they required unauthenticated administrative writes and hard-coded sample students.
