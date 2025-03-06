<p align="center">
  <a href="https://incloudsistemas.com.br" target="_blank">
    <img src="https://github.com/incloudsistemas/i2c15-starter-kit/blob/main/public/images/i2c-logo-large.png" 
    alt="The i2c | InCloud skeleton engine application logo.">
  </a>
</p>

# InCloudCodile15 - i2c | Starter Kit

InCloudCodile15 is a starter kit built on top of the [Laravel 12](https://laravel.com/) framework and the [TALL Stack](https://tallstack.dev/), leveraging [Filament v3](https://filamentphp.com/). It provides a robust and scalable foundation for businesses looking to streamline their operations and achieve their objectives efficiently.

## Requirements

- **Operating System**: Windows, macOS, or Linux
- **Web Server**: Apache or Nginx
- **PHP**: 8.2+
- **Node.js**: 18+ (LTS recommended)
- **Composer**: 2+
- **Database**: MySQL 8+

## Installation

### 1. Clone the repository and navigate into it

```bash
git clone https://github.com/incloudsistemas/i2c15-starter-kit.git
cd i2c15-starter-kit
```

### 2. Install backend dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Configure environment variables and generate app key

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Create a MySQL database and update `.env` with your database credentials

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run migrations and seeders

```bash
php artisan migrate --seed
```

### 7. Build frontend assets

```bash
npm run dev
```

### 8. Start development server

```bash
php artisan serve
```

## Security Vulnerabilities

If you discover a security vulnerability within InCloudCodile15, please report it by emailing Vinícius C. Lemos at [contato@incloudsistemas.com.br](mailto:contato@incloudsistemas.com.br). We take security seriously and will address all vulnerabilities promptly.

## License

InCloudCodile15 is an open-source project licensed under the [MIT license](https://opensource.org/licenses/MIT).
