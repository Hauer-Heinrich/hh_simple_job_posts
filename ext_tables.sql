CREATE TABLE tx_hhsimplejobposts_domain_model_jobpost (
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    maintasks text,
    profile text,
    weprovide text,
    others text,
    employment_type varchar(255) DEFAULT '' NOT NULL,
    hiring_organization int(11) unsigned DEFAULT '0',
    work_hours varchar(255) DEFAULT '' NOT NULL,

    base_salary_currency varchar(255) DEFAULT '' NOT NULL,
    base_salary_value int(11) unsigned DEFAULT '0' NOT NULL,

    slug varchar(2048),
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tt_address (
    tx_extbase_type varchar(255) DEFAULT '' NOT NULL
);
