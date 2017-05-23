-- This file describes the database schema

-- Required is a PostgreSQL Database version 9.1 or higher
-- Also installed must be PostGIS (http://postgis.net); Version 2.1 or higher

set statement_timeout = 0;
set client_encoding = 'UTF8';
set standard_conforming_strings = on;
set check_function_bodies = false;
set client_min_messages = warning;

-- Add required PostgreSQL extensions
create extension if not exists postgis;

-- Add table poi
create table poi (
    id serial,
    active boolean default true,
    category_id integer not null,
    location_text text,
    title text,
    description text,
    creation_timest timestamp without time zone default now(),
    location geometry,
    modified_timest timestamp without time zone default now(),
    owner_id integer,
    verified boolean
);

-- Add table poi_category
create table poi_category (
    id serial,
    active boolean default true,
    name text not null,
    icon text not null,
    iconw integer,
    iconh integer,
    iconx integer,
    icony integer,
    list_icon integer,
    display_order integer,
    description text not null,
    creation_timest timestamp without time zone default now(),
    multi_icon text,
    multi_iconw integer,
    multi_iconh integer,
    multi_iconx integer,
    multi_icony integer
);

-- Add table poi_owner
create table poi_owner (
    id serial,
    firstname text,
    lastname text,
    firm text,
    businesstype text,
    description text,
    creation_timest timestamp without time zone default now(),
    contacted boolean
);

-- Add table users
create table users (
    id serial,
    active boolean default true,
    name text not null,
    password text not null
);
