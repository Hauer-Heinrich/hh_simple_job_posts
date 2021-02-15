CREATE TABLE tx_hhsimplejobposts_domain_model_jobpost (
    title varchar(255) DEFAULT '' NOT NULL,
    description text,
    maintasks text,
    profile text,
    education_requirements text,
    experience_requirements text,
    skills text,
    weprovide text,
    others text,
    employment_type varchar(255) DEFAULT '' NOT NULL,
    hiring_organization int(11) unsigned DEFAULT '0',
    work_hours varchar(255) DEFAULT '' NOT NULL,

    base_salary_currency varchar(255) DEFAULT '' NOT NULL,
    base_salary_value double(10,2) unsigned DEFAULT '0' NOT NULL,

    contact_point_email varchar(255) DEFAULT '' NOT NULL,
    contact_point_telephone varchar(255) DEFAULT '' NOT NULL,
    contact_point_address int(11) unsigned DEFAULT '0',

    images int(11) unsigned DEFAULT '0',

    slug varchar(2048),
    categories int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tt_address (
    tx_extbase_type varchar(255) DEFAULT '' NOT NULL
);
