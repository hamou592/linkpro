🌐 SaaS LinkPro Platform

A SaaS platform built with Laravel, Blade, and MySQL that allows businesses and professionals to have their own LinkTree-style mini-website where all their important links, geolocation, QR code, and related content are grouped and displayed.

This project includes:

An admin panel for managing clients and their content.

A public landing page where each client has a unique showcase URL.

A modern, fully responsive UI optimized for all devices.

🚀 Features
🛠️ Admin Panel

👤 Authentication System: Only admins can access.

👥 Client Management (CRUD): Add, edit, delete, and view clients.

🔗 Content Management (CRUD): Add related links, geolocation, colors, and QR codes per client.

🔍 Filtering & Searching: Quickly search/filter clients or content.

🎨 QR Code Generation: Each client gets a personalized QR code pointing to their landing page.

🌍 Public Landing Page

📑 Client Showcase Pages: Each client has a dedicated URL such as:

/clinique-fares

/restaurant-cook

🔗 Links & Geolocation Display: Show grouped links, business details, and maps.

📱 Responsive Design: Optimized for desktop, tablet, and mobile.

🎨 Modern Friendly UI: Clean and professional design.

🛠️ Tech Stack

Backend: Laravel (PHP Framework)

Frontend: Blade Templates, HTML, CSS, JavaScript

Database: MySQL

Authentication: Laravel built-in auth system

QR Code Generator: Laravel package / integrated service

📂 Project Structure
saas-linktree/
│── app/                 # Laravel backend logic
│── resources/views/     # Blade templates (admin + client showcase)
│── public/              # Public assets (CSS, JS, images)
│── routes/web.php       # Application routes
│── database/            # Migrations & seeds
│── screenshots/         # Screenshots of UI
│── README.md            # Documentation

📸 Screenshots

🔑 Admin Login <img width="1103" height="632" alt="image" src="https://github.com/user-attachments/assets/351d18f6-1ea7-4ae1-bb84-b907fe5fa12b" />


📊 Admin Dashboard : 

👥 Client Management <img width="1905" height="912" alt="image" src="https://github.com/user-attachments/assets/44ae9ea0-7599-4b3e-83ec-103153951455" />
<img width="1902" height="910" alt="image" src="https://github.com/user-attachments/assets/05c4772b-764c-4c45-b5d6-7439be2aa807" />
<img width="1907" height="917" alt="image" src="https://github.com/user-attachments/assets/a043ea58-289f-4c81-8a7c-99b7adceb290" />
<img width="1908" height="917" alt="image" src="https://github.com/user-attachments/assets/c8d38704-1d46-475e-9936-f8ec84a1ac85" />


🔗 Content Creation (Links/Geolocation/QR code) <img width="1886" height="922" alt="image" src="https://github.com/user-attachments/assets/fa1e14ee-a34e-434a-a7d8-fbf177e1894e" />
<img width="1888" height="920" alt="image" src="https://github.com/user-attachments/assets/7ff732c7-02f0-4293-ae19-3a6950259a56" />


🌍 Landing Page (screenshot)

📑 Client Showcase Example (/clinique-fares) (screenshot)

📑 Client Showcase Example (/restaurant-cook) (screenshot)

⚙️ How It Works

Admin logs in → Accesses secure admin panel.

Admin creates a client → Adds client name, business type, etc.

Admin adds content → Links, geolocation, colors, QR code.

Client’s mini-site is generated automatically → Accessible via unique URL.

Visitors → Navigate to /client-name to see grouped links and details.

📦 Installation & Usage
🔽 Clone the repo
git clone [https://github.com/hamou592/saas-linktree.git](https://github.com/hamou592/linkpro.git)


📦 Install dependencies
composer install
npm install && npm run dev

⚙️ Setup environment

Copy .env.example to .env

cp .env.example .env


Configure database in .env:

DB_DATABASE=linkpro_db
DB_USERNAME=root
DB_PASSWORD=

🗄️ Run migrations
php artisan migrate

🔑 Generate app key
php artisan key:generate

🚀 Serve the app
php artisan serve


Now visit 👉 http://127.0.0.1:8000

Admin Panel → /admin

Client Showcase → /client-name

🔮 Future Improvements

Add subscription plans for clients (SaaS monetization).

Add analytics dashboard (track link clicks).

Add custom domains for clients.

👨‍💻 Author

Hamou Nasreddine – [GitHub Profile](https://github.com/hamou592)
