# Laravel 12 & Livewire 3 E-Commerce Store

A modern, full-featured e-commerce platform built with **Laravel 12**, **Livewire 3**, and **Flux UI**. This project provides a complete online shopping experience with customer management, product catalog, shopping cart, checkout process, and admin panel.

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.0-4E56A6?style=flat&logo=livewire&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0-38B2AC?style=flat&logo=tailwind-css&logoColor=white)

## ✨ Features

### 🛍️ Customer Features
- **Product Browsing**: Browse products with filtering and search capabilities
- **Product Details**: Detailed product pages with images, descriptions, and reviews
- **Shopping Cart**: Add, update, and remove items from cart
- **Wishlist**: Save favorite products for later
- **Checkout Process**: Streamlined checkout with address management
- **Order Management**: View order history and track order status
- **Product Reviews**: Rate and review purchased products
- **User Dashboard**: Personalized customer dashboard
- **Address Management**: Save multiple shipping/billing addresses

### 🔐 Authentication & Security
- **User Registration & Login**: Secure authentication powered by Laravel Fortify
- **Email Verification**: Verify user email addresses
- **Password Reset**: Forgot password functionality
- **Two-Factor Authentication**: Enhanced security with 2FA support
- **Profile Management**: Update user profile information

### 👨‍💼 Admin Features
- **Admin Dashboard**: Comprehensive admin panel
- **Product Management**: Create, update, and delete products
- **Category Management**: Organize products into categories
- **Coupon Management**: Create and manage discount coupons
- **Order Management**: View and manage customer orders

### ⚙️ Settings
- **Profile Settings**: Update personal information
- **Password Management**: Change account password
- **Appearance Settings**: Customize UI preferences
- **Two-Factor Authentication**: Enable/disable 2FA

## 🗄️ Database Schema

The application includes the following main entities:
- **Users**: Customer and admin accounts with role-based access
- **Products**: Product catalog with images and categories
- **Categories**: Product categorization
- **Orders**: Customer orders and order items
- **Payments**: Payment transaction records
- **Reviews**: Product reviews and ratings
- **Wishlists**: Customer wishlists
- **Addresses**: Customer shipping/billing addresses
- **Coupons**: Discount codes and promotions

## 🚀 Getting Started

### Prerequisites

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** or **Yarn**
- **SQLite** (or MySQL/PostgreSQL)

### Installation

1. **Clone the repository**
   ```bash
   git clone <your-repository-url>
   cd ecomm-lw3
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   
   Edit the `.env` file with your database credentials:
   ```env
   DB_CONNECTION=sqlite
   # DB_DATABASE=/absolute/path/to/database.sqlite
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database** (optional)
   ```bash
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

### Running the Application

#### Development Mode

Run all services concurrently (server, queue, logs, and Vite):
```bash
composer dev
```

This will start:
- Laravel development server (http://localhost:8000)
- Queue worker
- Application logs (Pail)
- Vite dev server for hot module replacement

#### Individual Services

Alternatively, run services separately:

**Start the development server:**
```bash
php artisan serve
```

**Watch and compile assets:**
```bash
npm run dev
```

**Run queue worker:**
```bash
php artisan queue:listen
```

**Monitor logs:**
```bash
php artisan pail
```

## 🧪 Testing

Run the test suite:
```bash
composer test
```

Or use Pest directly:
```bash
./vendor/bin/pest
```

## 📁 Project Structure

```
ecomm-lw3/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # HTTP controllers
│   │   └── Middleware/       # Custom middleware (AdminMiddleware)
│   ├── Livewire/
│   │   ├── Admin/            # Admin panel components
│   │   ├── Auth/             # Authentication components
│   │   ├── Customers/        # Customer dashboard components
│   │   ├── Settings/         # User settings components
│   │   └── Store/            # Storefront components
│   ├── Models/               # Eloquent models
│   └── Providers/            # Service providers
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── views/                # Blade templates
├── routes/
│   ├── web.php               # Web routes
│   └── auth.php              # Authentication routes
└── tests/                    # Test files
```

## 🛠️ Tech Stack

### Backend
- **Laravel 12**: PHP framework
- **Livewire 3**: Full-stack framework for Laravel
- **Livewire Volt**: Single-file Livewire components
- **Laravel Fortify**: Authentication backend
- **SQLite/MySQL**: Database

### Frontend
- **Livewire Flux**: Modern UI component library
- **TailwindCSS 4**: Utility-first CSS framework
- **Vite**: Frontend build tool
- **Axios**: HTTP client

### Development Tools
- **Laravel Pail**: Log viewer
- **Laravel Pint**: Code style fixer
- **Pest**: Testing framework
- **Laravel Sail**: Docker development environment (optional)

## 🔑 Key Routes

### Public Routes
- `/` - Homepage
- `/products` - Product listing
- `/product/{slug}` - Product details
- `/cart` - Shopping cart
- `/checkout` - Checkout page

### Customer Routes (Authenticated)
- `/customer/dashboard` - Customer dashboard
- `/customer/orders` - Order history
- `/customer/wishlist` - Wishlist
- `/customer/addresses` - Address management
- `/customer/reviews/edit/{productId}` - Product reviews

### Admin Routes (Admin Only)
- `/admin/dashboard` - Admin dashboard
- `/admin/products` - Product management
- `/admin/categories` - Category management
- `/admin/coupons` - Coupon management

### Settings Routes (Authenticated)
- `/settings/profile` - Profile settings
- `/settings/password` - Password management
- `/settings/appearance` - Appearance settings
- `/settings/two-factor` - Two-factor authentication

## 🔒 User Roles

The application supports role-based access control:
- **Customer**: Regular users who can browse and purchase products
- **Admin**: Administrators with access to the admin panel

## 📝 Configuration

### Admin Access

To create an admin user, update the `role` field in the `users` table:
```sql
UPDATE users SET role = 'admin' WHERE email = 'admin@example.com';
```

Or use a seeder to create admin users during database seeding.

### Email Configuration

Configure email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Livewire](https://livewire.laravel.com) - Full-stack framework for Laravel
- [Flux UI](https://flux.laravel.com) - Beautiful UI components
- [TailwindCSS](https://tailwindcss.com) - Utility-first CSS framework

## 📧 Contact

For questions or support, please open an issue in the GitHub repository.

---

**Built with ❤️ using Laravel 12 and Livewire 3**
