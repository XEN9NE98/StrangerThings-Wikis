# Stranger Things Wiki

A comprehensive Wikipedia-style website dedicated to the Netflix series "Stranger Things". This website allows users to explore and manage information about characters, episodes, quotes, and locations from the show.

## Features

### 1. Home Page
- **Dynamic Counters**: Displays real-time counts of Characters, Episodes, Quotes, and Locations
- **Quote of the Day**: Randomly displays a memorable quote from the series
- **Quick Navigation**: Easy access to all sections of the wiki

### 2. Characters Section
- Browse all characters from the show
- Each character card displays:
  - Character name
  - Actor's name
  - Character image
  - Description
  - Age, birth date, and height information
- Enhanced view page with:
  - Two-row responsive layout
  - High-quality character images
  - Detailed biographical information in styled info cards
  - Embedded YouTube clips for character moments
- Operations available:
  - **View**: See full character details in dedicated page
  - **Edit**: Modify character information
  - **Delete**: Remove a character

### 3. Episodes Section
- Complete episode listing organized by season
- Episode information includes:
  - Episode title
  - Season and episode number
  - Air date
  - Description
  - Thumbnail image
- Enhanced view page with:
  - Two-row responsive layout
  - Season and episode info cards with accent styling
  - Formatted air dates
  - Responsive 16:9 YouTube video player
- Full CRUD operations (Create, Read, Update, Delete)
- YouTube clip integration

### 4. Quotes Section
- Collection of memorable quotes from the series
- Each quote card shows:
  - The quote text
  - Context/description
  - Character who said it
  - Episode it appeared in
- Manage quotes with edit and delete options

### 5. Locations Section
- Explore iconic locations from Hawkins and beyond
- Location details include:
  - Location name
  - Description
  - High-quality images
  - Real-life location Maps links (Google Maps)
- Enhanced view page with:
  - Two-row responsive layout
  - Full-width "View Real-Life Location" button when Maps URL is available
  - Clean, modern design with icon-enhanced headers
- Complete management capabilities (Create, Read, Update, Delete)

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: 
  - HTML5
  - CSS3 (Custom styling with Stranger Things theme)
  - JavaScript/jQuery
  - Bootstrap 5.3
  - Font Awesome 6.4 for icons

## Installation

### Prerequisites
- XAMPP (or similar LAMP/WAMP stack)
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Setup Instructions

1. **Clone or Download the Project**
   - Place the `StrangerThings-Wikis` folder in your XAMPP `htdocs` directory
   - Path should be: `C:\xampp\htdocs\StrangerThings-Wikis`

2. **Create the Database**
   - Start XAMPP and ensure Apache and MySQL are running
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `database.sql` file to create the database and tables
   - The database will be created with sample data

3. **Configure Database Connection** (if needed)
   - Open `config/database.php`
   - Update database credentials if your setup differs:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'stranger_things_wiki');
     ```

4. **Access the Website**
   - Open your browser and navigate to: `http://localhost/StrangerThings-Wikis/home.php`

## Project Structure

```
StrangerThings-Wikis/
├── actions/                    # Backend PHP scripts for CRUD operations
│   ├── add_character.php
│   ├── edit_character.php
│   ├── get_character.php
│   ├── add_episode.php
│   ├── edit_episode.php
│   ├── get_episode.php
│   ├── add_quote.php
│   ├── edit_quote.php
│   ├── get_quote.php
│   ├── add_location.php
│   ├── edit_location.php
│   ├── get_location.php
│   └── delete.php
├── assets/                     # Static resources
│   ├── css/
│   │   └── style.css          # Custom Stranger Things themed styling
│   └── js/
│       └── script.js          # JavaScript functionality
├── config/
│   └── database.php           # Database configuration and helper functions
├── includes/
│   ├── header.php             # Reusable header with navigation
│   └── footer.php             # Reusable footer
├── home.php                   # Homepage with counters and quote of the day
├── characters.php             # Characters listing and management
├── view-character.php         # Individual character view page
├── episodes.php               # Episodes listing and management
├── view-episode.php           # Individual episode view page
├── quotes.php                 # Quotes listing and management
├── locations.php              # Locations listing and management
├── view-location.php          # Individual location view page
├── database.sql               # Database schema and sample data
└── README.md                  # This file
```

## Database Schema

### Tables

1. **characters**
   - id, name, actor_name, description, image_url, youtube_clip_url, age, born_date, height, created_at, updated_at

2. **episodes**
   - id, title, season, episode_number, description, image_url, youtube_clip_url, air_date, created_at, updated_at

3. **quotes**
   - id, quote_text, description, character_id (FK), episode_id (FK), created_at, updated_at

4. **locations**
   - id, name, description, image_url, maps_url, created_at, updated_at

## Features in Detail

### Theme
- Dark theme inspired by Stranger Things aesthetic
- Red and dark color scheme matching the show's branding (#e50914)
- Responsive design for mobile and desktop
- Smooth animations and hover effects
- Modern UI with display typography and info cards
- Improved contrast for better readability
- Icon-enhanced section headers using Font Awesome

### User Experience
- Intuitive navigation bar
- Modal-based forms for adding and editing content
- Confirmation dialogs before deleting items
- Real-time search and filtering capabilities
- Animated counter numbers on homepage

### Data Management
- All CRUD operations are handled via AJAX for smooth user experience
- Form validation on both client and server side
- Prepared statements for SQL security
- Automatic timestamp tracking

## Usage Guide

### Adding Content

1. **Add a Character**
   - Go to Characters page
   - Click "Add New Character" button
   - Fill in the form:
     - Name (required)
     - Actor name (required)
     - Description (required)
     - Image URL (required)
     - YouTube Clip URL (optional)
     - Age, birth date, height (optional)
   - Click "Add Character"

2. **Add an Episode**
   - Navigate to Episodes page
   - Click "Add New Episode"
   - Enter episode details including season, episode number, title, description
   - Click "Add Episode"

3. **Add a Quote**
   - Visit Quotes page
   - Click "Add New Quote"
   - Enter the quote text, context, and select associated character/episode
   - Submit the form

4. **Add a Location**
   - Go to Locations page
   - Click "Add New Location"
   - Provide:
     - Location name (required)
     - Description (required)
     - Image URL (required)
     - Real-life Location Maps URL (optional, e.g., Google Maps link)
   - Save the location

### Managing Content

- **View**: Click the "View" button to see full details in a dedicated page with enhanced layout
- **Edit**: Click "Edit" to modify existing information
- **Delete**: Click "Delete" to remove an item (confirmation required)
- **Watch Clip** (Characters/Episodes): Embedded YouTube players in view pages
- **View Real-Life Location** (Locations): Opens Google Maps link in new tab when available

## Customization

### Changing Theme Colors
Edit `assets/css/style.css` and modify the CSS variables:
```css
:root {
    --stranger-red: #e50914;
    --stranger-dark: #141414;
    --stranger-gray: #2f2f2f;
    --stranger-light: #f5f5f5;
}
```

### Modifying Database Connection
Update credentials in `config/database.php`

### Adding New Features
1. Create new PHP files in the root directory
2. Add corresponding action files in the `actions/` folder
3. Update the navigation in `includes/header.php`

## Troubleshooting

### Database Connection Issues
- Ensure MySQL is running in XAMPP
- Verify database credentials in `config/database.php`
- Check if database exists in phpMyAdmin

### Images Not Displaying
- Ensure image URLs are valid and accessible
- Check if images are using HTTPS if your site uses HTTPS

### AJAX Requests Failing
- Check browser console for JavaScript errors
- Verify file paths in AJAX calls
- Ensure jQuery is loaded properly

## Future Enhancements

Potential features to add:
- User authentication and authorization
- Image upload functionality
- Advanced search and filtering
- Character relationships mapping
- Timeline view for episodes
- Fan ratings and reviews
- Export data to PDF/CSV

## Credits

- **Framework**: Bootstrap 5.3
- **Icons**: Font Awesome 6.4
- **JavaScript Library**: jQuery 3.6
- **Inspiration**: Netflix's Stranger Things series

## License

This project is for educational purposes only. Stranger Things is a trademark of Netflix.

## Support

For issues or questions, please check:
1. Database connection settings
2. XAMPP status (Apache and MySQL running)
3. File permissions
4. Browser console for JavaScript errors

---

**Enjoy exploring the Upside Down! 🎮👾**
