#CREATE DATABASE IF NOT EXISTS challenge_db;
#USE challenge_db;

CREATE TABLE IF NOT EXISTS Hotel (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Room (
    id INT PRIMARY KEY,
    hotel_id INT,
    name VARCHAR(255) NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES Hotel(id)
);

CREATE TABLE IF NOT EXISTS Reserve (
    id INT PRIMARY KEY,
    hotel_id INT,
    room_id INT,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES Hotel(id),
    FOREIGN KEY (room_id) REFERENCES Room(id)
);
CREATE TABLE IF NOT EXISTS Daily (
    id INT PRIMARY KEY,
    reserve_id INT,
    date DATE NOT NULL,
    value DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (reserve_id) REFERENCES Reserve(id)
);

CREATE TABLE IF NOT EXISTS PaymentMethod (
    id INT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS Payment (
    id INT PRIMARY KEY,
    reserve_id INT,
    method_id INT,
    value DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (reserve_id) REFERENCES Reserve(id),
    FOREIGN KEY (method_id) REFERENCES PaymentMethod(id)
);

CREATE TABLE IF NOT EXISTS CouponCode (
    id INT PRIMARY KEY,
    code VARCHAR(50) NOT NULL, -- Código do cupom
    discount_type ENUM('percent', 'fixed') NOT NULL, -- 'percent' para percentual, 'fixed' para valor fixo
    value DECIMAL(10, 2) NOT NULL, -- Valor do desconto (percentual ou fixo, dependendo do tipo)
    description VARCHAR(255), -- Descrição do cupom
    start_date DATE, -- Data de início do cupom
    end_date DATE, -- Data de expiração do cupom
    max_uses INT DEFAULT 1, -- Número máximo de utilizações do cupom
    times_used INT DEFAULT 0, -- Número de vezes que o cupom foi utilizado
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de criação do cupom
);

CREATE TABLE IF NOT EXISTS Discount (
    id INT PRIMARY KEY,
    reserve_id INT, -- ID da reserva relacionada
    coupon_id INT, -- ID do cupom relacionado, se houver
    discount_type ENUM('percent', 'fixed') NOT NULL, -- Tipo de desconto: percentual ou fixo
    value DECIMAL(10, 2) NOT NULL, -- Valor do desconto (pode ser percentual ou fixo)
    description VARCHAR(255), -- Descrição do desconto
    FOREIGN KEY (reserve_id) REFERENCES Reserve(id),
    FOREIGN KEY (coupon_id) REFERENCES CouponCode(id)
);

CREATE TABLE IF NOT EXISTS Surcharge (
    id INT PRIMARY KEY,
    reserve_id INT, -- ID da reserva relacionada
    surcharge_type ENUM('service_fee', 'interest', 'other') NOT NULL, -- Tipo de acréscimo (taxa de serviço, juros, etc.)
    charge_type ENUM('percent', 'fixed') NOT NULL, -- 'percent' para percentual, 'fixed' para valor fixo
    value DECIMAL(10, 2) NOT NULL, -- Valor do acréscimo (percentual ou fixo, dependendo do tipo)
    description VARCHAR(255), -- Descrição do acréscimo (opcional)
    FOREIGN KEY (reserve_id) REFERENCES Reserve(id) -- Chave estrangeira para a reserva
);

CREATE TABLE IF NOT EXISTS Person (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL
);

CREATE TABLE IF NOT EXISTS User (
    id INT PRIMARY KEY,
    person_id INT UNIQUE,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50),
    FOREIGN KEY (person_id) REFERENCES Person(id)
);

CREATE TABLE IF NOT EXISTS Guest (
    id INT PRIMARY KEY,
    reserve_id INT,
    person_id INT UNIQUE,
    FOREIGN KEY (reserve_id) REFERENCES Reserve(id),
    FOREIGN KEY (person_id) REFERENCES Person(id)
);

