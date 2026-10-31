-- PostgreSQL Schema for BenHub

CREATE TABLE admin_info (
    ad_username VARCHAR(100),
    ad_password VARCHAR(100),
    ad_name VARCHAR(100)
);

INSERT INTO admin_info (ad_username, ad_password, ad_name) VALUES ('admin', '$2y$12$iralFISllAu.uyBT.5Q7re3TSlNKL5CGEhOYbhHinskCdJZiQj7R6', 'Administrator');

CREATE TABLE reservation_info (
    reservation_id SERIAL PRIMARY KEY,
    reservation_date DATE,
    reservation_time VARCHAR(10),
    num_guest INTEGER,
    reservation_floor VARCHAR(10),
    reservation_table VARCHAR(10),
    status VARCHAR(20) DEFAULT 'confirmed',
    occasion VARCHAR(100),
    special_request VARCHAR(1000),
    confirmation_code VARCHAR(20) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customer_info (
    customer_id INTEGER REFERENCES reservation_info(reservation_id) ON DELETE CASCADE,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    age INTEGER,
    contact_num VARCHAR(15),
    email_add VARCHAR(100)
);

CREATE TABLE restaurant_floors (
    floor_id SERIAL PRIMARY KEY,
    floor_name VARCHAR(50) UNIQUE NOT NULL,
    description VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO restaurant_floors (floor_name, description) VALUES
('Floor 1', 'Ground Floor - Main Dining & Window Area'),
('Floor 2', 'Second Floor - Lounge & Bar Area'),
('Floor 3', 'Third Floor - Private Function & VIP Rooms');

CREATE TABLE restaurant_tables (
    table_id SERIAL PRIMARY KEY,
    table_name VARCHAR(50) NOT NULL,
    floor_name VARCHAR(50) NOT NULL,
    capacity INTEGER NOT NULL,
    area VARCHAR(100) DEFAULT 'Dining Room',
    description VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (table_name, floor_name)
);

INSERT INTO restaurant_tables (table_name, floor_name, capacity, area) VALUES
('Table 1', 'Floor 1', 2, 'Window'),
('Table 2', 'Floor 1', 2, 'Window'),
('Table 3', 'Floor 1', 4, 'Main Dining'),
('Table 4', 'Floor 1', 4, 'Main Dining'),
('Table 5', 'Floor 1', 6, 'Main Dining'),
('Table 6', 'Floor 2', 4, 'Lounge'),
('Table 7', 'Floor 2', 4, 'Lounge'),
('Table 8', 'Floor 2', 6, 'Lounge'),
('Table 9', 'Floor 3', 8, 'Private Room'),
('Table 10', 'Floor 3', 12, 'Private Room');

CREATE UNIQUE INDEX unique_active_table_slot
ON reservation_info (reservation_date, reservation_time, reservation_floor, reservation_table)
WHERE status IN ('pending', 'confirmed', 'seated');

CREATE TABLE terms_conditions (
    tc_num INTEGER,
    tc_title VARCHAR(1000),
    tc_description VARCHAR(1000)
);

CREATE TABLE restaurant_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT NOT NULL,
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO restaurant_settings (setting_key, setting_value, description) VALUES
('restaurant_name', 'BenHub', 'Restaurant display brand name'),
('tagline', 'Reserve the right table for the right moment with clear availability, instant confirmation, and a smoother dining experience.', 'Hero subtitle/tagline'),
('operating_days', 'Monday - Saturday', 'Operating schedule days'),
('opening_time', '10:00 AM', 'Daily opening time'),
('closing_time', '6:00 PM', 'Daily closing time'),
('is_open_today', 'true', 'Whether the restaurant is currently accepting bookings / open'),
('phone_number', '+1 (555) 555-1234', 'Primary contact phone number'),
('email_address', 'info@example.com', 'Primary contact email address'),
('street_address', '1234 Imaginary Street', 'Physical street address'),
('city_address', 'Fictionville, Manila, Philippines', 'City and country location'),
('map_url', '#', 'External map link');

INSERT INTO terms_conditions (tc_num, tc_title, tc_description) VALUES
(1, 'Customer Arrival', 'To provide the highest level of service for all of our customers, we kindly ask that you arrive prepared to be seated at the time of your reservation. After being detained for ten minutes, the table might be given to another customer.'),
(2, 'Notification', 'We will notify you by email or text message a day before your reservation about your pending reservation at our restaurant.'),
(3, 'Outsider Foods', 'Outside food and beverages are not allowed inside our restaurant, but we do permit food from our restaurants to be taken out.'),
(4, 'Number of Guest/s', 'The number of guest/s who attend your reservation that exceeds the number of guest/s you select into our reservation form will be charged PHP 100 per head. Likewise, any damage to the property of our restaurant caused by customers will be charged accordingly as well.'),
(5, 'Cancelation Policy', 'There is strictly no cancellation of reservations. However, if absolutely needed, please contact us 5 hours or more before the time of reservation; this is for us to allocate your slots to other customers.'),
(6, 'Customer Personal Information', 'our first and last name, age, contact number, email address, home address, and allergies are among the personally identifiable data we will gather. BenHub will use your data in a private manner and will only use it for appropriate business purposes.'),
(7, 'Personal Information Security', 'We will only keep your personal information for as long as it takes to complete the tasks for which it was originally obtained. After our transactions, we will quickly remove it. Additionally, we''ll implement technical security measures to prevent the loss, unauthorized use, or alteration of your personal data.'),
(8, 'Third Party Websites', 'The privacy policies or procedures of websites operated by third parties are not subject to our control. As a result, you should make sure to read the relevant privacy policies before visiting such sites since we have no control over the data that is sent to or collected by these third parties.');
