# ProfitStream Blog

A modern blog platform built with [Laravel](https://laravel.com/), [Vue.js](https://vuejs.org/), [Inertia.js](https://inertiajs.com/), and [DaisyUI](https://daisyui.com/).

## Table of Contents

- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
  - [Clone repository](#installation)
  - [Install dependencies](#installation)
  - [Environment setup](#installation)
  - [Database configuration](#installation)
- [Development](#development)
- [Testing](#testing)
- [Production](#production)
- [Theme Configuration](#theme-configuration)
- [Contributing](#contributing)
- [License](#license)
- [Summary & Assumptions](#summary--assumptions)

## Features

- User authentication and authorization
- Blog post creation and management
- Draft/Published post status
- User profiles
- Follow system w/notifications
- Dark mode support with DaisyUI themes

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL or PostgreSQL

## Installation

1. Clone the repository
```bash
git clone https://github.com/codivist/ProfitStream.git
```
2. Install PHP dependencies
```bash
composer install
```
3. Install NPM & dependencies
```bash
npm install
```
* Install daisyui - If you have cloned the repo from the main branch, daisyui is already installed. Otherwise, run: `npm install daisyui`

4. Copy .env.example to .env and configure your database settings
```bash
cp .env.example .env
```
5. Generate application key
```bash
php artisan key:generate
```
6. Configure your database in the .env file
    * don't forget to create the database on your server (:scream_cat: I use Docker/Sail)
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=profitstream
DB_USERNAME=root
DB_PASSWORD=your_magical_secret_password
```
7. Run migrations
```bash
php artisan migrate:install
php artisan migrate
```
8. Seed the database
    * This will create a a handfull of users and a several blog posts to get you started. Prepare to be blown away by Lorem Ipsum.
```bash
php artisan db:seed
```
9. Blog Post notifications are sent via Laravel's Queueing system via email. You can use either:
    * A real email server
    * [mailhog](https://github.com/mailhog/MailHog) server. To view the emails sent, run `mailhog` and navigate to `http://localhost:8025/`.
    * [Mailtrap.io](https://mailtrap.io/) (recommended as this is an easy setup and you can test with dummy emails, *and your emails won't be sent to random people by mistake, like you did that one time... yeah we've all been there* :grimacing:)
    * Just update the `.env` file with your email server details in the `MAIL_MAILER` section

## Development
1. Start the development server (or use Docker :shrug:)
```bash
php artisan serve
```
2. Run Vue dev server
```bash
npm run dev
```
3. Run Linting
```bash
npm run lint
```

## Testing
1. Run tests
    * Tests are run with [PestPHP](https://pestphp.com/)
    * at the time of writing, they were all passing :tada:
```bash
php artisan test
```

## Production
1. Build assets
```bash
npm run build
```
2. Run production server
```bash
php artisan serve
```

## Theme Configuration

The application uses DaisyUI for theming. Available themes:
- dracula
- forest
- nord

To change the theme, modify the `data-theme` attribute in `resources/views/app.blade.php`.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Details about Darth Vader' and what you did`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

[Don't worry I have a permit for that](https://www.youtube.com/watch?v=uq6nBigMnlg)

# Summary & Assumptions

## Summary
I approached this project with the goal of creating a modern, feature-rich blog platform that is easy to use and maintain. Using Laravel, Inertia, Vue, and DaisyUI, I was able to create a responsive and dynamic blog platform that is easy to use and maintain.

Vuejs was used for the frontend as it allowed me to create a dynamic and responsive user interface. Inertiajs was used for the frontend/backend communication as it allowed me to create the application with page transitions and route handling.

DaisyUI was used as I personally prefer the ease-of-use compared to tailwindCSS. Keep me off my soapbox.

I took some liberties on this project and added a feature that allows the user to publish/unpublish posts. It will also show the publish status in the UI.

:star2: Also to note, I added my tests as I was architecting the project. I'm a big fan of testing and I try to stick to TDD when possible. :star2:

## Assumptions
* I assume you enjoy Star Wars as much as I do. Even though I don't reference it in the code, I should have added a few easter eggs. I can add that in v.2.0
* I've assumed that the blog posts will be the main focus of the website and that the user will want to read the blog posts.
* I've assumed that the user will want to follow other users and be notified when they publish a new blog post.
* I've assumed that the user will want to be able to view other users posts.
* Sorry for the bad jokes, I'll try to do better next time.

## Thank you & Dad Joke
Thank you for your time and consideration on considering me for the Lead Software Engineer position. If you have any questions, please feel free to reach out to me.
```
What do you call a typo on a headstone?
A grave mistake.
```
Sorry, not sorry.