NOTE APP 2026 - FINAL PROJECT README
====================================
524H0076 - Hoang Thai An

524H0036 - Le Ngoc Bao Tran
1. PROJECT OVERVIEW
-------------------
Project name: NoteNest / Note App 2026

This is a note management web application for the Web Programming & Applications final project.
The application supports account management, note management, auto-save, tags, image attachments,
password-protected notes, note sharing, realtime collaboration, and offline/PWA capability.

Technologies:
- Backend: Laravel 12, PHP 8.2+
- Frontend: Blade, CSS, JavaScript, Vite
- Database: MySQL
- Realtime: Laravel Broadcasting + Laravel Reverb WebSocket
- Offline/PWA: Service Worker, Web App Manifest, IndexedDB


2. SYSTEM REQUIREMENTS
----------------------
- PHP 8.2 or newer
- Composer
- Node.js and npm
- MySQL or MariaDB
- Chrome, Edge, or Firefox


3. INSTALLATION
---------------
Open a terminal in the project root:

    G:\PHP\note-app-2026

Install PHP dependencies:

    composer install

Install JavaScript dependencies:

    npm install

Create .env file:

    copy .env.example .env

Generate application key:

    php artisan key:generate

Configure database in .env:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=note_app_2026
    DB_USERNAME=root
    DB_PASSWORD=

Create a MySQL database named:

    note_app_2026

Run migrations:

    php artisan migrate

Optional seed account:

    php artisan db:seed

Create storage link for uploaded avatars and note images:

    php artisan storage:link

Build frontend assets:

    npm run build


4. RUNNING THE PROJECT
----------------------
Run Laravel server:

    php artisan serve

Default URL:

    http://127.0.0.1:8000

For development assets:

    npm run dev

For realtime collaboration, run Reverb in another terminal:

    php artisan reverb:start


5. REALTIME CONFIGURATION
-------------------------
Make sure .env contains:

    BROADCAST_CONNECTION=reverb
    REVERB_APP_ID=local-notenest
    REVERB_APP_KEY=local-notenest-key
    REVERB_APP_SECRET=local-notenest-secret
    REVERB_HOST=localhost
    REVERB_PORT=8080
    REVERB_SCHEME=http

    VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
    VITE_REVERB_HOST="${REVERB_HOST}"
    VITE_REVERB_PORT="${REVERB_PORT}"
    VITE_REVERB_SCHEME="${REVERB_SCHEME}"

Note: Auto-save still works even if Reverb is not running. Reverb is required only for realtime
collaboration between users.


6. MAIL CONFIGURATION
---------------------
For local testing, mail can be logged instead of actually sent:

    MAIL_MAILER=log

Email features used by the application:
- Account verification
- Password reset
- Share note notification

To send real emails, configure SMTP in .env.


7. SAMPLE AND EXISTING ACCOUNTS
-------------------------------
Seeder account:

If you run:

    php artisan db:seed

the project creates:

    Email: test@example.com
    Password: password

Existing accounts currently available in the provided local database:

    1. Email: lengocbaotran2006123@gmail.com
       Password: Tran@1209

    2. Email: hoangthaian.7942@gmail.com
       Password: thaian252506

    3. Email: thaian5553979@gmail.com
        Password: 123456an

Important password note:
The application stores passwords as bcrypt hashes, so the original plain-text passwords cannot be
read from the database. Please use the passwords originally created for these accounts by the team.
If a guaranteed test account is needed, run "php artisan db:seed" and use test@example.com/password.

For testing share notes and realtime collaboration, use two different accounts in two browsers.


8. IMPLEMENTED FEATURES
-----------------------
Account management:
- User registration
- User login and logout
- Email verification notification
- Password reset support
- View and edit profile
- Upload avatar
- Change password
- User preferences
- Light/dark theme
- Default grid/list view preference

Simple note management:
- Grid view and list view
- Create notes
- Update notes
- Delete notes with confirmation dialog
- Auto-save notes without Save button
- Attach images to notes
- Insert images at cursor position inside editor
- Delete images and auto-save updated content
- Pin notes to top
- Live search by title and content
- Tags/labels
- Select previously used tags
- Filter notes by tag

Advanced note management:
- Enable password protection on notes
- Unlock notes with password
- Change or remove note password
- Share notes with registered users
- Read-only and edit permissions
- Share to multiple recipients
- Share while creating a note
- Shared notes section
- Owner can update permission or revoke access
- Realtime collaboration for editable shared notes
- Icons for pinned, shared, and password-protected notes

Other requirements:
- Responsive UI
- Light/dark theme
- Custom dropdowns and polished UI components
- PWA manifest
- Service worker
- Offline page
- IndexedDB local draft/pending-save storage
- Synchronize queued changes when online again


9. DEMO GUIDE
-------------
Recommended checking flow:

1. Register or log in.
2. Open Profile and update avatar/display name.
3. Open Preferences and switch light/dark theme.
4. Open Notes.
5. Create a new note.
6. Type title/content and confirm auto-save status becomes "Saved".
7. Add tags and select existing tags.
8. Attach an image and confirm it appears at the cursor position.
9. Delete the image and confirm it stays deleted after reload.
10. Pin a note.
11. Use live search and tag filter.
12. Lock a note with password and unlock it.
13. Share a note with another registered user.
14. Log in as recipient and check Shared page.
15. Give edit permission and test realtime collaboration in two browsers.
16. Turn browser network offline, edit a note, then turn online and confirm sync.


10. IMPORTANT FILES
-------------------
Routes:
routes/web.php
routes/auth.php
routes/channels.php

Controllers:
app/Http/Controllers/NoteController.php
app/Http/Controllers/NotePasswordController.php
app/Http/Controllers/ProfileController.php
app/Http/Controllers/PreferenceController.php

Services:
app/Services/NoteService.php

Models:
app/Models/Note.php
app/Models/NoteTag.php
app/Models/User.php

Realtime:
app/Events/NoteUpdated.php
config/broadcasting.php
config/reverb.php

Frontend:
resources/views
resources/js/app.js
resources/css/app.css

PWA/offline:
public/manifest.json
public/sw.js
resources/views/offline.blade.php


11. TROUBLESHOOTING
-------------------
Vite manifest error:

    npm run build
    php artisan view:clear
    php artisan config:clear

Uploaded images or avatars do not show:

    php artisan storage:link

Realtime collaboration does not work:

    php artisan reverb:start

Database tables are missing:

    php artisan migrate

Sample account does not exist:

    php artisan db:seed

