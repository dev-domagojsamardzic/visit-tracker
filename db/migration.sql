CREATE TABLE IF NOT EXISTS visits (
    visitor_id VARCHAR(10) NOT NULL,
    page VARCHAR(512) NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (visitor_id, page, date)
);
