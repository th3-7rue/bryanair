import datetime
import random

# Define the route and number of flights per day
departure_airport =230   # Alicante 
arrival_airport =  817   # Bologna
aircraft = 24  
airline = 2  

# Define the start and end dates
start_date = datetime.datetime(2025, 11, 17)
end_date = datetime.datetime(2026, 5, 2)

# Define the time intervals for each day (departure times)
time_intervals = [
    [datetime.timedelta(hours=15, minutes=45)],  # Monday
    [datetime.timedelta(hours=8, minutes=45)],   # Tuesday
    [datetime.timedelta(hours=13, minutes=55)],  # Wednesday
    [],  # Thursday
    [],  # Friday
    [datetime.timedelta(hours=23, minutes=0)],  # Saturday
    [datetime.timedelta(hours=22, minutes=35)]   # Sunday
]

# Initialize the SQL query
sql_query = "INSERT INTO `flights` (`departure_airport`, `arrival_airport`, `departure_datetime`, `arrival_datetime`, `aircraft`, `airline_id`, `base_price`) VALUES\n"

# Generate SQL queries for each day
current_date = start_date
def calculate_base_price(day_of_week, date):
    """Calculate the base price based on the day of the week and seasonality."""
    base_price = 100.0  # Default base price

    # Adjust base price based on day of the week
    if day_of_week in [4, 5, 6]:  # Friday, Saturday, Sunday (typically higher demand)
        base_price *= 1.2  # Increase base price by 20%

    # Adjust base price based on seasonality (e.g., summer vs. winter)
    if date.month in [6, 7, 8]:  # Summer months (higher demand)
        base_price *= 1.1  # Increase base price by 10%
    elif date.month in [1, 2, 12]:  # Winter months (lower demand)
        base_price *= 0.9  # Decrease base price by 10%

    return base_price


def apply_dynamic_pricing(base_price, date):
    """Apply dynamic pricing based on demand, booking window, etc."""
    # Simulate random fluctuations in price (for demonstration purposes)
    random_factor = random.uniform(0.9, 1.1)  # Random factor between 0.9 and 1.1
    final_price = base_price * random_factor

    # Apply additional adjustments based on booking window (days before departure)
    days_before_departure = (date - datetime.datetime.now()).days
    if days_before_departure < 7:  # Less than a week before departure
        final_price *= 1.2  # Increase price by 20% for last-minute bookings

    return round(final_price, 2)  # Round final price to 2 decimal places

while current_date <= end_date:
    # Get the day of the week (0 = Monday, 1 = Tuesday, ..., 6 = Sunday)
    day_of_week = current_date.weekday()

    if time_intervals[day_of_week]:  # Check if there are any flight times for this day
        departure_datetime = current_date + time_intervals[day_of_week][0]
        arrival_datetime = departure_datetime + datetime.timedelta(hours=2, minutes=10)  # Flight duration

        # Determine base price based on day of the week and season
        base_price = calculate_base_price(day_of_week, current_date)

        # Apply dynamic pricing based on demand, booking window, etc.
        final_price = apply_dynamic_pricing(base_price, current_date)

        # Append flight details to SQL query
        sql_query += f"({departure_airport}, {arrival_airport}, '{departure_datetime.strftime('%Y-%m-%d %H:%M:%S')}', '{arrival_datetime.strftime('%Y-%m-%d %H:%M:%S')}', {aircraft}, {airline}, {final_price}),\n"

    # Move to the next day
    current_date += datetime.timedelta(days=1)

# Remove the trailing comma and newline
sql_query = sql_query.rstrip(",\n")

# Print the SQL query
print(sql_query+";")


