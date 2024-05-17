# Define seat layout (6 columns, 197 total seats)
NUM_COLUMNS = 6
NUM_SEATS = 189

# Define fare class IDs
fare_classes = [1, 2, 3, 4, 5, 6, 7, 8, 9]

# Function to generate seat number
def generate_seat_number(row, col):
  return f"{row}{chr(col + 65)}"  # Convert column number (0-5) to letter (A-F)

# Generate INSERT statements
insert_statements = []
aircraft_id = 25  # Replace with desired aircraft ID
row = 1

for seat_number in range(1, NUM_SEATS + 1):
  # Determine fare class for this seat
  fare_class_id = fare_classes[seat_number % len(fare_classes)]  # Cycle through fare classes

  # Calculate column based on seat number
  col = (seat_number - 1) % NUM_COLUMNS

  # Generate seat number
  seat = generate_seat_number(row, col)

  # Check if we need to move to the next row
  if col == NUM_COLUMNS - 1:
    row += 1

  # Build INSERT statement
  insert_statements.append(f"INSERT INTO seats_aircraft (number, fare_class, aircraft) VALUES ('{seat}', {fare_class_id}, {aircraft_id});")

# Combine all INSERT statements into a single string
insert_string = "\n".join(insert_statements)

print(insert_string)
