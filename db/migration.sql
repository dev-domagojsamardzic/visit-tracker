CREATE TABLE IF NOT EXISTS visits (
    visitor_id VARCHAR(16) NOT NULL,
    page VARCHAR(1024) NOT NULL,
    date DATE NOT NULL,
    count BIGINT NOT NULL DEFAULT 0,
    PRIMARY KEY (visitor_id, page, date)
);
