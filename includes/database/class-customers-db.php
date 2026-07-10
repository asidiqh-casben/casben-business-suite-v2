<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CBS_Customers_DB {

    /**
     * Create Customers Table
     */
    public static function create_table() {

        global $wpdb;

        $table_name = $wpdb->prefix . 'cbs_customers';

        $charset_collate = $wpdb->get_charset_collate();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = "CREATE TABLE {$table_name} (

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            customer_code VARCHAR(30) NOT NULL,

            customer_name VARCHAR(200) NOT NULL,

            contact_person VARCHAR(150) NULL,

            phone VARCHAR(50) NULL,

            mobile VARCHAR(50) NULL,

            email VARCHAR(150) NULL,

            website VARCHAR(200) NULL,

            ntn VARCHAR(50) NULL,

            strn VARCHAR(50) NULL,

            address TEXT NULL,

            city VARCHAR(100) NULL,

            province VARCHAR(100) NULL,

            country VARCHAR(100) DEFAULT 'Pakistan',

            postal_code VARCHAR(20) NULL,

            credit_limit DECIMAL(18,2) DEFAULT 0,

            opening_balance DECIMAL(18,2) DEFAULT 0,

            status TINYINT(1) DEFAULT 1,

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            PRIMARY KEY (id),

            UNIQUE KEY customer_code (customer_code),

            KEY customer_name (customer_name),

            KEY phone (phone),

            KEY email (email)

        ) {$charset_collate};";

        dbDelta($sql);
    }

}