CREATE TABLE IF NOT EXISTS visits (
    visitor_id VARCHAR(10) NOT NULL,
    page VARCHAR(512) NOT NULL,
    date DATE NOT NULL,
    count BIGINT NOT NULL DEFAULT 1,
    PRIMARY KEY (visitor_id, page, date)
);
