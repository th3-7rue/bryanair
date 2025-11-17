# Bryanair

Bryanair is a flight booking system that allows users to search for and book flights to various destinations. This project aims to provide a user-friendly interface for customers to easily find and book their desired flights.

## Features

- Flight search: Users can search for flights based on their preferred departure and destination airports, as well as the desired travel dates.
- Flight booking: Once users find their desired flight, they can proceed to book it by providing their personal information and payment details.
- User authentication: Users can create accounts and log in to access their booking history and manage their profile.
- Booking management: Users can view their booked flights bookings.

## Demo

https://github.com/th3-7rue/bryanair/assets/66943187/4bd6d04c-1ee4-4046-ae5b-bc607ac33f1a

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/th3-7rue/bryanair.git
   ```

2. Install the required dependencies:

   ```bash
   npm install
   composer install
   ```

3. Set up the database:

   - Create a new database in your preferred database management system.
   - Import the `bryanair.sql` file into the newly created database.
   - Copy the `.env.example` file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```

   - Update the database configuration in the `.env` file with your database credentials.

4. Migrate the database:
    - Delete table users
    - Do migrations:
   ```bash
   php artisan migrate
   ```

5. Start the application (use two separate terminals):

   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```
## FAQ

**Q: I can't see any airport**

**A:** If you can't see any airport when using the app, it is very likely that there are just no *future* flights planned. You might want to generate them with *generaVoli.py*, or manually add them.

**Q: I get errors when using *composer install***

**A:** There are two probable causes:

1. Laravel dependancies are not updated
   
   **Solution**
   
   ```bash
   composer update
   ```
2. PHP dynamic extensions are disabled

   You need to check if a file named *php.ini* exist in your PHP folder. If not, create it and copy *php.ini-development* content into it.

   If you already have php.ini, search for *Dynamic Extensions*, scroll down a bit and remove the semicolons before the required extensions. (If you do not know which ones are required, you may just enable them all **except** for snmp)

## Technologies Used

- MySQL
- TALL stack (Tailwind CSS, Alpine.js, Livewire, Laravel)

## Contributing

Contributions are welcome! If you'd like to contribute to Bryanair, please follow these steps:

1. Fork the repository.
2. Create a new branch.
3. Make your changes and commit them.
4. Push your changes to your forked repository.
5. Submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

## Contact

If you have any questions or suggestions, feel free to reach out to us at [riccardorasori2005@gmail.com](mailto:riccardorasori2005@gmail.com).
