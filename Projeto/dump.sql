--
-- PostgreSQL database dump
--

-- Dumped from database version 11.15
-- Dumped by pg_dump version 11.15

-- Started on 2023-03-02 03:02:36 -03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 3200 (class 0 OID 0)
-- Dependencies: 3
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 203 (class 1259 OID 187531)
-- Name: product; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product (
    id integer NOT NULL,
    name text,
    product_type_id integer NOT NULL
);


ALTER TABLE public.product OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 187529)
-- Name: product_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_id_seq OWNER TO postgres;

--
-- TOC entry 3201 (class 0 OID 0)
-- Dependencies: 202
-- Name: product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_id_seq OWNED BY public.product.id;


--
-- TOC entry 205 (class 1259 OID 187542)
-- Name: product_price; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_price (
    id integer NOT NULL,
    product_id integer NOT NULL,
    created_at timestamp with time zone,
    price numeric
);


ALTER TABLE public.product_price OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 187540)
-- Name: product_price_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_price_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_price_id_seq OWNER TO postgres;

--
-- TOC entry 3202 (class 0 OID 0)
-- Dependencies: 204
-- Name: product_price_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_price_id_seq OWNED BY public.product_price.id;


--
-- TOC entry 197 (class 1259 OID 187501)
-- Name: product_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_type (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.product_type OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 187499)
-- Name: product_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_type_id_seq OWNER TO postgres;

--
-- TOC entry 3203 (class 0 OID 0)
-- Dependencies: 196
-- Name: product_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_type_id_seq OWNED BY public.product_type.id;


--
-- TOC entry 199 (class 1259 OID 187512)
-- Name: product_type_tax; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_type_tax (
    id integer NOT NULL,
    created_at timestamp with time zone,
    tax numeric,
    product_type_id integer NOT NULL
);


ALTER TABLE public.product_type_tax OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 187510)
-- Name: product_type_tax_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_type_tax_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_type_tax_id_seq OWNER TO postgres;

--
-- TOC entry 3204 (class 0 OID 0)
-- Dependencies: 198
-- Name: product_type_tax_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_type_tax_id_seq OWNED BY public.product_type_tax.id;


--
-- TOC entry 201 (class 1259 OID 187523)
-- Name: sale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sale (
    id integer NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.sale OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 187521)
-- Name: sale_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sale_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sale_id_seq OWNER TO postgres;

--
-- TOC entry 3205 (class 0 OID 0)
-- Dependencies: 200
-- Name: sale_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sale_id_seq OWNED BY public.sale.id;


--
-- TOC entry 207 (class 1259 OID 187553)
-- Name: sale_product; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sale_product (
    id integer NOT NULL,
    product_type_tax_id integer,
    sale_id integer NOT NULL,
    product_price_id integer NOT NULL,
    amount numeric
);


ALTER TABLE public.sale_product OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 187551)
-- Name: sale_product_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sale_product_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sale_product_id_seq OWNER TO postgres;

--
-- TOC entry 3206 (class 0 OID 0)
-- Dependencies: 206
-- Name: sale_product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sale_product_id_seq OWNED BY public.sale_product.id;


--
-- TOC entry 3041 (class 2604 OID 187534)
-- Name: product id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product ALTER COLUMN id SET DEFAULT nextval('public.product_id_seq'::regclass);


--
-- TOC entry 3042 (class 2604 OID 187545)
-- Name: product_price id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_price ALTER COLUMN id SET DEFAULT nextval('public.product_price_id_seq'::regclass);


--
-- TOC entry 3037 (class 2604 OID 187504)
-- Name: product_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type ALTER COLUMN id SET DEFAULT nextval('public.product_type_id_seq'::regclass);


--
-- TOC entry 3038 (class 2604 OID 187515)
-- Name: product_type_tax id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type_tax ALTER COLUMN id SET DEFAULT nextval('public.product_type_tax_id_seq'::regclass);


--
-- TOC entry 3039 (class 2604 OID 187526)
-- Name: sale id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale ALTER COLUMN id SET DEFAULT nextval('public.sale_id_seq'::regclass);


--
-- TOC entry 3043 (class 2604 OID 187556)
-- Name: sale_product id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_product ALTER COLUMN id SET DEFAULT nextval('public.sale_product_id_seq'::regclass);


--
-- TOC entry 3190 (class 0 OID 187531)
-- Dependencies: 203
-- Data for Name: product; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product (id, name, product_type_id) FROM stdin;
12	Liquidificador	19
13	Banana	16
14	Maçã	16
15	Uva verde sem caroço	16
16	TV	19
17	Patinho	18
18	Alface	17
19	Rúcula	17
20	Tomate	16
21	Repolho	17
\.


--
-- TOC entry 3192 (class 0 OID 187542)
-- Dependencies: 205
-- Data for Name: product_price; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_price (id, product_id, created_at, price) FROM stdin;
10	17	2023-03-01 23:12:39.92786-03	40
11	12	2023-03-01 23:12:46.371281-03	100
12	16	2023-03-01 23:12:52.814955-03	3000
13	13	2023-03-01 23:13:01.712373-03	8.99
14	14	2023-03-01 23:13:17.075261-03	11.55
15	20	2023-03-01 23:13:25.894291-03	8.99
16	15	2023-03-01 23:13:34.493317-03	13.59
17	18	2023-03-01 23:13:51.646122-03	4.99
18	21	2023-03-01 23:13:59.257034-03	10
19	19	2023-03-01 23:14:08.789025-03	6.99
\.


--
-- TOC entry 3184 (class 0 OID 187501)
-- Dependencies: 197
-- Data for Name: product_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_type (id, name) FROM stdin;
17	Legumes/ Verduras
18	Carnes
16	Frutas
19	Eletrodomésticos
20	Cama/Mesa/Banho
\.


--
-- TOC entry 3186 (class 0 OID 187512)
-- Dependencies: 199
-- Data for Name: product_type_tax; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_type_tax (id, created_at, tax, product_type_id) FROM stdin;
9	2023-03-01 23:14:24.198121-03	2	18
10	2023-03-01 23:14:31.858623-03	25	19
11	2023-03-01 23:14:37.712832-03	5	16
12	2023-03-01 23:14:41.861357-03	2	17
\.


--
-- TOC entry 3188 (class 0 OID 187523)
-- Dependencies: 201
-- Data for Name: sale; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sale (id, created_at) FROM stdin;
47	2023-03-02 02:43:28-03
46	2023-03-02 00:54:13-03
\.


--
-- TOC entry 3194 (class 0 OID 187553)
-- Dependencies: 207
-- Data for Name: sale_product; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sale_product (id, product_type_tax_id, sale_id, product_price_id, amount) FROM stdin;
24	9	46	10	3
25	10	46	11	1
26	10	47	11	10
27	10	47	12	30
\.


--
-- TOC entry 3207 (class 0 OID 0)
-- Dependencies: 202
-- Name: product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_id_seq', 21, true);


--
-- TOC entry 3208 (class 0 OID 0)
-- Dependencies: 204
-- Name: product_price_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_price_id_seq', 19, true);


--
-- TOC entry 3209 (class 0 OID 0)
-- Dependencies: 196
-- Name: product_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_type_id_seq', 20, true);


--
-- TOC entry 3210 (class 0 OID 0)
-- Dependencies: 198
-- Name: product_type_tax_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_type_tax_id_seq', 14, true);


--
-- TOC entry 3211 (class 0 OID 0)
-- Dependencies: 200
-- Name: sale_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sale_id_seq', 47, true);


--
-- TOC entry 3212 (class 0 OID 0)
-- Dependencies: 206
-- Name: sale_product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sale_product_id_seq', 27, true);


--
-- TOC entry 3051 (class 2606 OID 187539)
-- Name: product pk_product; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT pk_product PRIMARY KEY (id);


--
-- TOC entry 3053 (class 2606 OID 187550)
-- Name: product_price pk_product_price; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_price
    ADD CONSTRAINT pk_product_price PRIMARY KEY (id);


--
-- TOC entry 3045 (class 2606 OID 187509)
-- Name: product_type pk_product_type; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type
    ADD CONSTRAINT pk_product_type PRIMARY KEY (id);


--
-- TOC entry 3047 (class 2606 OID 187520)
-- Name: product_type_tax pk_product_type_tax; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type_tax
    ADD CONSTRAINT pk_product_type_tax PRIMARY KEY (id);


--
-- TOC entry 3049 (class 2606 OID 187528)
-- Name: sale pk_sale; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale
    ADD CONSTRAINT pk_sale PRIMARY KEY (id);


--
-- TOC entry 3055 (class 2606 OID 187561)
-- Name: sale_product pk_sale_product; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_product
    ADD CONSTRAINT pk_sale_product PRIMARY KEY (id);


--
-- TOC entry 3057 (class 2606 OID 187567)
-- Name: product fk_product_0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT fk_product_0 FOREIGN KEY (product_type_id) REFERENCES public.product_type(id);


--
-- TOC entry 3058 (class 2606 OID 187572)
-- Name: product_price fk_product_price_0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_price
    ADD CONSTRAINT fk_product_price_0 FOREIGN KEY (product_id) REFERENCES public.product(id);


--
-- TOC entry 3056 (class 2606 OID 187562)
-- Name: product_type_tax fk_product_type_tax_0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type_tax
    ADD CONSTRAINT fk_product_type_tax_0 FOREIGN KEY (product_type_id) REFERENCES public.product_type(id);


--
-- TOC entry 3059 (class 2606 OID 187577)
-- Name: sale_product fk_sale_product_0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_product
    ADD CONSTRAINT fk_sale_product_0 FOREIGN KEY (product_type_tax_id) REFERENCES public.product_type_tax(id);


--
-- TOC entry 3060 (class 2606 OID 187582)
-- Name: sale_product fk_sale_product_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_product
    ADD CONSTRAINT fk_sale_product_1 FOREIGN KEY (sale_id) REFERENCES public.sale(id);


--
-- TOC entry 3061 (class 2606 OID 187587)
-- Name: sale_product fk_sale_product_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_product
    ADD CONSTRAINT fk_sale_product_2 FOREIGN KEY (product_price_id) REFERENCES public.product_price(id);


-- Completed on 2023-03-02 03:02:37 -03

--
-- PostgreSQL database dump complete
--

