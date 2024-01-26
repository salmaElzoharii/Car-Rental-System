CREATE DATABASE carRentalSystem;
use carRentalSystem;
Create table Customer(
    customer_id int NOT NULL auto_increment,
    fname varchar(255) not null,
    lname varchar(255) not null,
    email varchar(100)not null,
    C_password varchar(100) NOT null,
    DOB date not null,
    phoneNumber int not null,
    address varchar(255) not null,
    PRIMARY KEY(customer_id)
    );
Create table Admin(
    fname varchar(255) not null,
    lname varchar(255) not null,
    email varchar(100)not null,
    AdminPassword varchar(100) NOT null
    );
CREATE TABLE Car(
    plate_id varchar(100) NOT NULL,
    Car_year int NOT null,
    model varchar(100) NOT NULL,
    availability_status varchar(100) not null,
    price float NOT null,
    brand varchar(100) NOT null,
    location varchar(100) NOT null,
    image_path VARCHAR(255) NOT NULL,
    PRIMARY KEY(plate_id)
    );
CREATE table Reservation(
    reservation_id int NOT  null,
    reservation_date timestamp NOT null,
    return_date date NOT null,
    pickup_date date not null,
    customer_id int NOT null,
    plate_id varchar(100) not null,
    numOfDays int not null,
    totalPrice float not null,
    FOREIGN KEY(plate_id) 
        REFERENCES Car(plate_id)
        ON DELETE CASCADE,
    FOREIGN KEY(customer_id) 
        REFERENCES Customer(customer_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (reservation_id, customer_id, plate_id)
    );
    Create table Rent(
        Rent_ID int NOT  null,
        paymentDate date not null,
        reservation_id int not null,
        totalprice float not null,
        FOREIGN KEY (reservation_id) REFERENCES reservation (reservation_id) ON DELETE CASCADE ON UPDATE CASCADE
        
        );
 ALTER TABLE rent ADD PRIMARY KEY (Rent_id);
alter table rent modify column Rent_id int NOT null AUTO_INCREMENT;
alter table rent add COLUMN cardNumber varchar(100) NOT NULL;
alter table rent add COLUMN cvv varchar(100) NOT NULL; 


