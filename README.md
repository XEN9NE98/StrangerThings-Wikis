# Stranger Things Wiki - BIT21503 Web Dev Project (Group 4)

A comprehensive Wikipedia-style website dedicated to the Netflix series "Stranger Things". This project allows users to explore, contribute, and manage information about characters, episodes, quotes, and locations from the show with full user authentication and content management capabilities.

## 🌟 Key Features

### User Authentication & Account Management
- **User Registration**: Create an account to contribute to the wiki
- **Secure Login**: Email-based authentication with hashed passwords
- **Account Management**:
  - Update username and email
  - Change password with current password verification
  - Delete account permanently (with confirmation)
- **Password Recovery**: Reset forgotten passwords via email using PHPMailer with explicit account existence checks
- **Session Management**: Secure session-based authentication
- **Login/Logout Notifications**: Toast-style alerts for authentication actions

### 1. Home Page
- **Dynamic Counters**: Real-time counts of Characters, Episodes, Quotes, and Locations
- **Quote of the Day**: Randomly displays a memorable quote from the series with character and episode attribution
- **Quick Navigation**: Intuitive access to all sections
- **User Dashboard**: Shows welcome message for logged-in users

### 2. Characters Section
- Browse all characters with detailed information
- Character cards display:
  - Name, actor, and high-quality image
  - Description (truncated to 2 lines with "..." for preview)
  - Age, birth date, and height
  - Interactive "View" button for full details
- Full character view page with:
  - Complete biographical information
  - Embedded YouTube character clips
  - Styled info cards with key details
- **Authenticated User Operations**:
  - Add new characters
  - Edit character information (powered by AJAX modal)
  - Delete characters (with confirmation)

### 3. Episodes Section
- Complete episode listing organized by season
- Episode cards include:
  - Title, season, episode number
  - Air date
  - Detailed description preview (2-line truncation)
  - Episode thumbnail
- Enhanced episode view page with:
  - Full episode details in styled cards
  - Season and episode number information
  - Formatted air dates
  - Embedded 16:9 YouTube video players
- Full CRUD operations for authenticated users (Add/Edit/Delete)

### 4. Quotes Section
- Curated collection of memorable quotes
- Quote cards display:
  - The quote text
  - Context/description
  - Associated character
  - Related episode
  - Interactive view/edit/delete buttons
- Full management for authenticated users

### 5. Locations Section
- Explore iconic Hawkins locations and other settings
- Location cards feature:
  - Name and description (2-line preview)
  - High-quality images
  - Links to real-world locations (Google Maps)
  - Interactive buttons for full details
- Full location view page with:
  - Complete descriptions
  - High-resolution images
  - "View Real-Life Location" button when Maps URL available
  - Modern responsive design
- Complete management capabilities for authenticated users

## 🛠 Technology Stack

- **Backend**: PHP 7.4+ with MySQLi
- **Database**: MySQL 5.7+
- **Frontend**: 
  - HTML5 / CSS3
  - JavaScript / jQuery
  - Bootstrap 5.3
  - Font Awesome 6.4 (icons)
- **Email**: PHPMailer 7.0 + phpdotenv 5.5
- **Authentication**: Password hashing (PHP PASSWORD_DEFAULT)
- **Environment Management**: dotenv for configuration

## 📋 Installation

### Prerequisites
- XAMPP 7.4+ (or similar LAMP/WAMP stack)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer (for dependency management)

### Setup Instructions

1. **Clone or Download the Project**
   ```bash
   # Place in XAMPP htdocs directory
   # Path: C:\xampp\htdocs\StrangerThings-Wikis
   ```

2. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

3. **Create the Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database or import from `database.sql`
   - The schema includes sample characters, episodes, locations, and quotes

4. **Install Dependencies**
   ```bash
   cd C:\xampp\htdocs\StrangerThings-Wikis
   composer install
   ```
   This installs:
   - PHPMailer for email functionality
   - phpdotenv for environment variable management

5. **Configure Environment**
   - Copy `.env.example` to `.env`
   - Configure required variables:
     ```
     GMAIL_ADDRESS=your-email@gmail.com
     GMAIL_PASSWORD=your-app-password
     MAIL_FROM_ADDRESS=noreply@strangerthingswiki.com
     MAIL_FROM_NAME="Stranger Things Wiki"
     APP_URL=http://localhost/StrangerThings-Wikis
     DB_HOST=localhost
     DB_USER=root
     DB_PASSWORD=
     DB_NAME=stranger_things_wiki
     ```

6. **Run Database Migration** (for existing installations)
   - If upgrading from version without password reset, run:
   ```
   http://localhost/StrangerThings-Wikis/migrate_add_password_reset.php
   ```
   - This adds `password_reset_token` and `password_reset_expires` columns

7. **Access the Application**
   ```
   http://localhost/StrangerThings-Wikis/
   ```

## 📁 Project Structure

```
StrangerThings-Wikis/
├── actions/                           # Backend PHP request handlers
│   ├── login.php                     # Handle user login
│   ├── logout.php                    # Handle user logout
│   ├── register.php                  # Handle user registration
│   ├── forgot_password.php           # Handle password reset requests (Checks account existence)
│   ├── reset_password.php            # Process password reset
│   ├── change_password.php           # Change password (authenticated)
│   ├── update_account.php            # Update profile (authenticated)
│   ├── delete_account.php            # Delete account (authenticated)
│   ├── require_login.php             # Middleware for protected pages
│   ├── add_character.php             # Add character
│   ├── edit_character.php            # Edit character
│   ├── get_character.php             # Fetch character data
│   ├── add_episode.php               # Add episode
│   ├── edit_episode.php              # Edit episode
│   ├── get_episode.php               # Fetch episode data
│   ├── add_quote.php                 # Add quote
│   ├── edit_quote.php                # Edit quote
│   ├── get_quote.php                 # Fetch quote data
│   ├── add_location.php              # Add location
│   ├── edit_location.php             # Edit location
│   ├── get_location.php              # Fetch location data
│   └── delete.php                    # Generic delete handler
├── assets/                            # Frontend assets
│   ├── css/
│   │   └── style.css                 # Stranger Things theme + responsive design
│   ├── image/                        # Images and logos
│   └── js/
│       └── script.js                 # Client-side functionality (Includes dynamic modal handling)
├── config/
│   ├── database.php                  # Database connection & helper functions
│   └── email.php                     # Email configuration & sendEmail() function
├── includes/
│   ├── header.php                    # Navigation bar & authenticated user menu
│   └── footer.php                    # Footer template
├── index.php                         # Home page with stats & quote
├── login.php                         # Login page
├── register.php                      # Registration page
├── manage_account.php                # Account settings (authenticated)
├── characters.php                    # Characters listing & management
├── view-character.php                # Individual character details
├── episodes.php                      # Episodes listing & management
├── view-episode.php                  # Individual episode details
├── locations.php                     # Locations listing & management
├── view-location.php                 # Individual location details
├── quotes.php                        # Quotes listing & management
├── reset_password.php                # Password reset form (token-based)
├── forgot_password.php               # Standalone forgot password page
├── migrate_add_password_reset.php    # Database migration script
├── database.sql                      # Database schema & sample data
├── composer.json                     # PHP dependencies (PHPMailer, phpdotenv)
├── composer.lock                     # Locked dependency versions
├── .env.example                      # Environment variables template
├── .env                              # Environment configuration (git-ignored)
└── README.md                         # This file
```

## 🗄 Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    password_reset_token VARCHAR(64),
    password_reset_expires DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Characters Table
```sql
CREATE TABLE characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    actor_name VARCHAR(100),
    description TEXT,
    image_url VARCHAR(500),
    youtube_clip_url VARCHAR(500),
    age INT,
    born_date DATE,
    height VARCHAR(20),
    created_at TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Episodes, Quotes, Locations
Similar structure with relevant fields for each entity

## 🎨 Design & Theme

### Stranger Things Aesthetic
- **Primary Color**: Red (#e50914) for buttons, accents, and interactive elements
- **Background**: Dark (#141414) for immersive atmosphere
- **Text**: Light (#f5f5f5) for high contrast readability
- **Accents**: Gray (#2f2f2f) for secondary elements

### Visual Features
- **Truncated Descriptions**: Card descriptions limited to 2 lines with ellipsis for preview
- **Auto-dismiss Notifications**: Login/logout alerts disappear after 5 seconds
- **Responsive Layout**: Mobile-first design works on all screen sizes
- **Smooth Animations**: Hover effects and transitions for better UX
- **Bootstrap Components**: Modals, cards, tabs, and alerts for consistent UI

## 🔐 Authentication & Security

### User Registration
- Email validation (RFC format)
- Password hashing using PHP PASSWORD_DEFAULT (bcrypt)
- Duplicate email/username prevention
- Session-based authentication

### Login
- Email + password verification
- Hashed password comparison
- Session creation on successful login
- Error messages for invalid credentials

### Password Management
- **Forgot Password**: Email-based reset links (1-hour expiry)
  - *Security Update*: Checks if account exists before sending email to prevent spam/abuse
- **Change Password**: Current password verification required
- **Password Reset**: Secure token-based reset process
- **Password Policy**: Minimum 6 characters for reset, 8+ for account changes
- **No Reuse**: Prevents setting password to same value

### Account Deletion
- Password confirmation required
- Immediate session destruction
- Permanent data removal from database
- Clean session cleanup

### Protected Pages
- `actions/require_login.php` middleware redirects unauthenticated users
- Applied to: Manage Account, content creation/editing for users

## 📧 Email Configuration

### Gmail Setup (Recommended for Development)
1. Enable 2-Factor Authentication on Google Account
2. Generate App Password:
   - Go to Google Account → Security
   - Select "Mail" and "Other (Custom name)"
   - Copy the 16-character password
3. Update `.env`:
   ```
   GMAIL_ADDRESS=your-email@gmail.com
   GMAIL_PASSWORD=xxxx xxxx xxxx xxxx
   ```

### Alternative Providers
- Use Mailtrap.io for testing (free tier)
- Update `config/email.php` with provider SMTP settings

### Troubleshooting Email
- See `PASSWORD_RECOVERY_TROUBLESHOOTING.md` for detailed guidance
- Check PHP error logs at `C:\xampp\php\logs\php_error_log`
- Enable debug mode in `config/email.php`: `$mail->SMTPDebug = 2;`

## 📖 Usage Guide

### For Visitors (Without Account)
1. Browse characters, episodes, locations, quotes
2. View full details for any item
3. Click "Login" or "Register" to contribute

### For Contributors (Registered Users)
1. **Register**: Create account on `/register.php`
2. **Login**: Access `/login.php` with email and password
3. **Add Content**: Click "Add New [Item]" on any section
4. **Edit Content**: Click "Edit" button on item cards
   - A modal will appear pre-filled with the item's current data
5. **Delete Content**: Click "Delete" (confirmation required)
6. **Manage Account**: Click username → "Account Settings"
   - Update email/username
   - Change password
   - Delete account permanently

### Password Recovery
1. Go to Login page
2. Click "Forgot password?" button
3. Enter email address
4. If account exists, check email for reset link (valid 1 hour)
5. Click link and enter new password
6. Login with new credentials

## 🎯 Customization

### Changing Theme Colors
Edit `assets/css/style.css`:
```css
:root {
    --stranger-red: #e50914;      /* Primary action color */
    --stranger-dark: #141414;     /* Background */
    --stranger-gray: #2f2f2f;     /* Secondary elements */
    --stranger-light: #f5f5f5;    /* Text color */
}
```

### Modifying Database Connection
Update `config/database.php` or `.env`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'stranger_things_wiki');
define('DB_PORT', 3306);
```

### Adding New Content Types
1. Create database table with proper schema
2. Create list page (`new-items.php`)
3. Create detail page (`view-new-item.php`)
4. Add handlers in `actions/` folder:
   - `add_new-item.php`
   - `edit_new-item.php`
   - `get_new-item.php`
5. Update navigation in `includes/header.php`

## 🐛 Troubleshooting

### Database Issues
- **Connection Failed**: Verify MySQL running, check credentials in `config/database.php`
- **Missing Tables**: Import `database.sql` in phpMyAdmin
- **Missing Columns**: Run `migrate_add_password_reset.php` for password reset functionality

### Authentication Issues
- **Login Not Working**: Check `$_SESSION` is enabled in PHP
- **Session Lost**: Clear browser cookies and try again
- **Password Reset Email Not Received**: Check `.env` configuration and email logs

### Email Not Sending
- Check Gmail is configured with App Passwords (2FA required)
- Verify `.env` has correct credentials
- Enable debug in `config/email.php`: `$mail->SMTPDebug = 2;`
- Check `C:\xampp\php\logs\php_error_log` for errors

### Content Not Displaying
- Verify images URLs are valid and accessible
- Check browser console for JavaScript errors
- Clear browser cache (Ctrl+Shift+Delete)
- Ensure file permissions allow reading (chmod 644)

## 📚 Dependencies

- **Bootstrap 5.3**: UI Framework
- **Font Awesome 6.4**: Icon library
- **jQuery 3.6**: JavaScript library
- **PHPMailer 7.0**: Email sending
- **phpdotenv 5.5**: Environment variable management

## 📄 License

This project is for educational purposes. "Stranger Things" is a Netflix trademark and intellectual property.

## 👨‍💻 Support & Contribution

For issues or improvements:
1. Check troubleshooting section above
2. Review error logs in browser console and PHP error log
3. Verify environment configuration in `.env`
4. Test with sample data from `database.sql`