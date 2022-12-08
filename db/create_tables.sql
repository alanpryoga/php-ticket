CREATE TABLE events
(
    id          INT             NOT NULL AUTO_INCREMENT,
    name        VARCHAR(20)     NOT NULL,
    created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id)
);

CREATE TABLE tickets
(
    id          INT             NOT NULL AUTO_INCREMENT,
    event_id    INT             NOT NULL,
    code        CHAR(15)        NOT NULL,
    status      VARCHAR(20)     NOT NULL DEFAULT 'available',
    created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id)
);

INSERT INTO events (name) VALUES
('Senin Ceria'),
('Selasa Ceria'),
('Rabu Ceria'),
('Kamis Ceria'),
('Jumat Ceria'),
('Sabtu Ceria'),
('Minggu Ceria');
