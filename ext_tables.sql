CREATE TABLE tx_hhsimplejobposts_domain_model_jobpost (
    title varchar(255) DEFAULT '' NOT NULL,
    short_description text,
    description text,
    maintasks text,
    profile text,
    education_requirements text,
    experience_requirements text,
    skills text,
    weprovide text,
    others text,
    employment_type varchar(255) DEFAULT '' NOT NULL,
    work_hours varchar(255) DEFAULT '' NOT NULL,

    hiring_organization int(11) unsigned DEFAULT '0',
    job_location int(11) unsigned DEFAULT '0',
    job_locations text NOT NULL,

    base_salary_currency varchar(255) DEFAULT '' NOT NULL,
    base_salary_value double(10,2) unsigned DEFAULT '0' NOT NULL,
    base_salary_value_max double(10,2) unsigned DEFAULT '0' NOT NULL,
    base_salary_unit_text varchar(255) DEFAULT '' NOT NULL,

    contact_point_email varchar(255) DEFAULT '' NOT NULL,
    contact_point_telephone varchar(255) DEFAULT '' NOT NULL,
    contact_point_address int(11) unsigned DEFAULT '0',

    images int(11) unsigned DEFAULT '0',

    slug varchar(2048),
    categories int(11) unsigned DEFAULT '0' NOT NULL,

    og_title varchar(255) DEFAULT '' NOT NULL,
    og_description text,
    og_image int(11) unsigned DEFAULT '0' NOT NULL,

    twitter_title varchar(255) DEFAULT '' NOT NULL,
    twitter_description text,
    twitter_image int(11) unsigned DEFAULT '0' NOT NULL,
    twitter_card varchar(255) DEFAULT '' NOT NULL,

    apiUid int(11) unsigned DEFAULT '0' NOT NULL,
    application_form varchar(255) DEFAULT '' NOT NULL,
);

CREATE TABLE tt_address (
    tx_extbase_type varchar(255) DEFAULT '' NOT NULL
);
