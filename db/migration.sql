CREATE TABLE IF NOT EXISTS visits (
    page VARCHAR(255) NOT NULL,
    visitor_id VARCHAR(10) NOT NULL,
    timestamp DATETIME NOT NULL,
    PRIMARY KEY (page, visitor_id)
);

CREATE INDEX idx_timestamp ON visits (timestamp);
