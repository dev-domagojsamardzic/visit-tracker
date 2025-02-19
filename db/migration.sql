# Composite primary key is added to ensure uniqe constraint
# (date, page, visitor_id) order is because of query select ... where date ...
CREATE TABLE IF NOT EXISTS visits (
    visitor_id CHAR(10) NOT NULL,
    page VARCHAR(512) NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (date, page, visitor_id)
);
