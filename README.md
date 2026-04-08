# TaskFlow - Task Management System

A modern, responsive task management application built with Laravel 10, featuring user authentication, real-time collaboration, and a beautiful dark/light theme interface.

## 🚀 Features

### Core Functionality
- ✅ **Complete Task Management**: Create, edit, delete, and track tasks
- ✅ **User Authentication**: Secure login/registration with Laravel Breeze
- ✅ **Task Organization**: Group tasks by subjects and priorities
- ✅ **Status Tracking**: Pending, In Progress, Completed states
- ✅ **Task Comments**: Add comments to tasks for collaboration
- ✅ **Search & Filtering**: Find tasks by status, subject, or keywords

### User Experience
- ✅ **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- ✅ **Dark/Light Theme**: Toggle between themes with persistent preference
- ✅ **Modern UI**: Clean, consistent design with custom CSS variables
- ✅ **Flash Messages**: Real-time feedback for user actions
- ✅ **Email Integration**: Password reset emails via Gmail SMTP

### Technical Features
- ✅ **Laravel 10**: Latest framework with modern PHP features
- ✅ **Database Design**: 5-table relational structure (users, tasks, subjects, priorities, comments)
- ✅ **Form Validation**: Comprehensive client and server-side validation
- ✅ **Authorization**: Users can only access their own data
- ✅ **Error Handling**: Try-catch blocks with user-friendly messages

## 🛠️ Tech Stack

- **Backend**: Laravel 10, PHP 8.1+
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Frontend**: Blade templates, Tailwind CSS, Custom CSS
- **Authentication**: Laravel Breeze
- **Email**: Gmail SMTP
- **Version Control**: Git + GitHub

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & npm
- Git

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/taskflow.git
   cd taskflow
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed  # Optional: adds sample priorities
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Visit: http://localhost:8000
   - Register a new account or login

## 👥 Team Collaboration

This project follows a structured collaboration workflow:

### Branching Strategy
- `main` - Production-ready code
- `develop` - Integration branch for features
- `feature/*` - Individual feature branches
- `bugfix/*` - Bug fix branches

### Development Workflow
1. **Create feature branch**: `git checkout -b feature/your-feature-name`
2. **Make changes**: Implement your assigned task
3. **Test thoroughly**: Ensure functionality works
4. **Commit changes**: `git commit -m "Add: descriptive commit message"`
5. **Push branch**: `git push origin feature/your-feature-name`
6. **Create Pull Request**: Request code review
7. **Merge after approval**: Team lead merges to develop/main

### Task Assignment

#### Frontend Team
- [ ] Improve mobile responsiveness
- [ ] Add loading animations
- [ ] Implement drag-and-drop task reordering
- [ ] Add task templates
- [ ] Create dashboard widgets

#### Backend Team
- [ ] Add task file attachments
- [ ] Implement task sharing between users
- [ ] Add email notifications for due dates
- [ ] Create API endpoints for mobile app
- [ ] Add task time tracking

#### QA Team
- [ ] Write comprehensive test cases
- [ ] Perform cross-browser testing
- [ ] Test email functionality
- [ ] Validate responsive design
- [ ] Security testing

#### DevOps Team
- [ ] Set up CI/CD pipeline
- [ ] Configure production deployment
- [ ] Database optimization
- [ ] Performance monitoring
- [ ] Backup strategies

## 📝 Contributing

1. **Fork the repository**
2. **Create your feature branch** (`git checkout -b feature/amazing-feature`)
3. **Commit your changes** (`git commit -m 'Add some amazing feature'`)
4. **Push to the branch** (`git push origin feature/amazing-feature`)
5. **Open a Pull Request**

### Code Review Process
- All PRs require at least 1 approval
- Code must pass automated tests
- Follow PSR-12 coding standards
- Include proper documentation

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Team

- **Project Lead**: [Your Name]
- **Frontend**: [Team Member 1]
- **Backend**: [Team Member 2]
- **QA**: [Team Member 3]
- **DevOps**: [Team Member 4]

## 📞 Support

For questions or issues:
- Create an issue on GitHub
- Contact the team lead
- Check the documentation

---

**Happy task managing with TaskFlow! 🎯**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
