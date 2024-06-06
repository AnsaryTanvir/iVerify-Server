CREATE TABLE products_information(
    
    id INT AUTO_INCREMENT,
    generic_id VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    manufacturer VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE products(
  
    id INT AUTO_INCREMENT,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    generic_id VARCHAR(255) NOT NULL,
    batch_id VARCHAR(255) NOT NULL,
    expiry VARCHAR(255) NOT NULL,
    verification_status VARCHAR(255) DEFAULT NULL,
    verification_identity VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY(id)
);