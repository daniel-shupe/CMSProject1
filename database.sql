CREATE TABLE access_levels(
    access_level_id tinyint NOT NULL UNIQUE AUTO_INCREMENT,
    description tinytext NOT NULL,
    PRIMARY KEY (access_level_id)
);

INSERT INTO access_levels(description) VALUES ('Admin'),('Staff'),('Customer');

CREATE TABLE accounts(
    account_id int NOT NULL UNIQUE AUTO_INCREMENT,
    username tinytext NOT NULL,
    first_name tinytext NOT NULL,
    last_name tinytext NOT NULL,
    email tinytext NOT NULL,
    phone varchar(20) NOT NULL,
    password tinytext NOT NULL,
    last_login timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    access_level_id tinyint NOT NULL DEFAULT 3, 
    enabled BOOLEAN NOT NULL,
    PRIMARY KEY (account_id),
    CONSTRAINT FK_AccessAccount FOREIGN KEY (access_level_id)
    REFERENCES access_levels(access_level_id)
);

CREATE TABLE news(
    news_id int NOT NULL UNIQUE AUTO_INCREMENT,
    account_id int NOT NULL,
    post_title tinytext NOT NULL,
    post_content mediumtext NOT NULL,
    post_date timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (news_id),
    FOREIGN KEY (account_id)
    REFERENCES accounts (account_id)
    ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE content_types(
    content_type_id int NOT NULL UNIQUE AUTO_INCREMENT,
    name tinytext NOT NULL UNIQUE,
    PRIMARY KEY (content_type_id)
);

CREATE TABLE products(
    product_id int NOT NULL UNIQUE AUTO_INCREMENT,
    name tinytext,
    short_description tinytext,
    long_description text,
    image tinytext,
    price float,
    content_type_id int NOT NULL,
    PRIMARY KEY (product_id),
    FOREIGN KEY (content_type_id)
    REFERENCES content_types (content_type_id)
    ON UPDATE RESTRICT ON DELETE CASCADE 
);

INSERT INTO content_types(name) VALUES ('Source Book'), ('Adventure Module'), ('Dice'), ('Miscellaneous');

CREATE TABLE orders(
    order_id int NOT NULL UNIQUE AUTO_INCREMENT,
    account_id int NOT NULL,
    total float NOT NULL,
    date timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (order_id),
    FOREIGN KEY (account_id)
    REFERENCES accounts (account_id)
    ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE order_products(
    order_id int NOT NULL,
    product_id int NOT NULL,
    quantity int NOT NULL,
    cost float NOT NULL,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE bags(
    bag_id int NOT NULL AUTO_INCREMENT,
    account_id int NOT NULL,
    active BOOLEAN NOT NULL DEFAULT 1,
    PRIMARY KEY (bag_id),
    FOREIGN KEY (account_id)
    REFERENCES accounts (account_id)
    ON UPDATE RESTRICT ON DELETE CASCADE
);

CREATE TABLE bag_products(
    bag_id int NOT NULL,
    product_id int NOT NULL,
    quantity int,
    cost float NOT NULL,
    PRIMARY KEY (bag_id, product_id),
    FOREIGN KEY (bag_id) REFERENCES bags(bag_id) ON UPDATE RESTRICT ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON UPDATE RESTRICT ON DELETE CASCADE
);

SELECT a.account_id, a.username, o.order_id, o.date, o.total, op.product_id, op.quantity, op.cost, p.name FROM accounts a
INNER JOIN orders o ON o.account_id = a.account_id WHERE account_id = ?
INNER JOIN order_products op ON o.order_id=op.order_id
INNER JOIN products p ON op.product_id=p.product_id
ORDER BY o.order_id;