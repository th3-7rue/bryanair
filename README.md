# Bryanair

Bryanair is a flight booking system that allows users to search for and book flights to various destinations. This project aims to provide a user-friendly interface for customers to easily find and book their desired flights.

## Features

- Flight search: Users can search for flights based on their preferred departure and destination airports, as well as the desired travel dates.
- Flight booking: Once users find their desired flight, they can proceed to book it by providing their personal information and payment details.
- User authentication: Users can create accounts and log in to access their booking history and manage their profile.
- Booking management: Users can view their booked flights bookings.

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

   ```bash
   php artisan migrate
   ```

5. Start the application (use two separate terminals):

   ```bash
   php artisan serve
   npm run dev
   ```

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
