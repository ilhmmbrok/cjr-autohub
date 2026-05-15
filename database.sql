    -- ============================================================
    --  AutoHub Database Schema
    --  Urutan CREATE penting: users dulu, baru tabel yang FK ke users
    -- ============================================================

    CREATE TABLE users (
        id         INT          NOT NULL AUTO_INCREMENT,
        fullname   VARCHAR(100) NOT NULL,
        email      VARCHAR(100) NOT NULL,
        phone      VARCHAR(20)      NULL,
        password   VARCHAR(255) NOT NULL,
        role       ENUM('admin','customer') NOT NULL DEFAULT 'customer',
        created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        UNIQUE KEY uq_users_email (email)
    );

    -- ------------------------------------------------------------

    CREATE TABLE business_hours (
        id            INT  NOT NULL AUTO_INCREMENT,
        slot_capacity INT  NOT NULL,
        open_time     TIME NOT NULL,
        close_time    TIME NOT NULL,
        updated_by    INT  NULL,
        updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (id),
        CONSTRAINT fk_bh_updated_by
            FOREIGN KEY (updated_by) REFERENCES users(id)
            ON DELETE SET NULL
    );

    -- ------------------------------------------------------------

    CREATE TABLE bookings (
        booking_id         INT          NOT NULL AUTO_INCREMENT,
        customer_id        INT          NOT NULL,
        admin_id           INT              NULL,
        phone              VARCHAR(20)  NOT NULL,
        address            VARCHAR(255) NOT NULL,
        vehicle_type       VARCHAR(50)  NOT NULL,
        model_year         VARCHAR(100) NOT NULL,
        plate_number       VARCHAR(20)  NOT NULL,
        customer_complaint TEXT         NOT NULL,
        booking_date       DATE         NOT NULL,
        checkin_time       TIME         NOT NULL,
        progress_status    ENUM('Pending','Admin Approved','In Progress','Completed','Cancelled')
                        NOT NULL DEFAULT 'Pending',
        created_at         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
                                        ON UPDATE CURRENT_TIMESTAMP,

        PRIMARY KEY (booking_id),
        INDEX idx_bookings_date   (booking_date),
        INDEX idx_bookings_customer (customer_id),

        CONSTRAINT fk_bookings_customer
            FOREIGN KEY (customer_id) REFERENCES users(id)
            ON DELETE CASCADE,
        CONSTRAINT fk_bookings_admin
            FOREIGN KEY (admin_id) REFERENCES users(id)
            ON DELETE SET NULL
    );
