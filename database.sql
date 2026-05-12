CREATE TABLE IF NOT EXISTS users(
    user_id BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    age TINYINT(3) UNSIGNED NOT NULL DEFAULT 18,
    country VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    social_media_url VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP not null ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP not null
);

CREATE TABLE IF NOT EXISTS transactions(
    id BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP not null,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP not null,
    user_id BIGINT(20) NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS receipts(
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  original_filename varchar(255) NOT NULL,
  storage_filename varchar(255) NOT NULL,
  media_type varchar(255) NOT NULL,
  transaction_id bigint(20) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY(transaction_id) REFERENCES transactions (id) ON DELETE CASCADE
);