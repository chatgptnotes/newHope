<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Landing Page</title>
	<meta name="title" content="Doclab - home">
	<meta name="description" content="This is a medical html template made by codewithsadee">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
		rel="stylesheet">

	<style>
		:root {
			--rich-black-fogra-29: hsl(222, 44%, 8%);
			--middle-blue-green_40: hsla(174, 64%, 71%, 0.4);
			--midnight-green: hsl(186, 100%, 19%);
			--midnight-green_a25: hsla(186, 100%, 19%, 0.25);
			--independece: hsl(236, 14%, 39%);
			--verdigris: hsl(182, 100%, 35%);
			--ming: hsl(186, 72%, 24%);
			--space-cadet: hsla(226, 45%, 24%);
			--eerie-black: hsl(0, 0%, 13%);
			--alice-blue: hsl(187, 25%, 94%);
			--gray-web: hsl(0, 0%, 50%);
			--gainsboro: hsl(0, 0%, 87%);
			--white: hsl(0, 0%, 100%);
			--white_a20: hsla(0, 0%, 100%, 0.2);
			--white_a10: hsla(0, 0%, 100%, 0.1);
			--black: hsl(0, 0%, 0%);

			--ff-oswald: 'Oswald', sans-serif;
			--ff-rubik: 'Rubik', sans-serif;

			--headline-lg: 5rem;
			--headline-md: 3rem;
			--headline-sm: 2rem;
			--title-lg: 1.8rem;
			--title-md: 1.5rem;
			--title-sm: 1.4rem;

			--fw-500: 500;
			--fw-700: 700;

			--section-padding: 120px;

			--shadow-1: 0px 2px 20px hsla(209, 36%, 72%, 0.2);
			--shadow-2: 0 4px 16px hsla(0, 0%, 0%, 0.06);

			--radius-circle: 50%;
			--radius-12: 12px;
			--radius-6: 6px;
			--radius-4: 4px;

			--transition-1: 0.25s ease;
			--transition-2: 0.5s ease;
			--transition-3: 1s ease;
			--cubic-in: cubic-bezier(0.51, 0.03, 0.64, 0.28);
			--cubic-out: cubic-bezier(0.05, 0.83, 0.52, 0.97);
		}

		*,
		*::before,
		*::after {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		li {
			list-style: none;
		}

		a,
		img,
		span,
		time,
		input,
		button,
		ion-icon {
			display: block;
		}

		a {
			color: inherit;
			text-decoration: none;
		}

		img {
			height: auto;
		}

		input{
			background: none;
	
			font: inherit;
		}
		button {
			background: none;
			border: none;
			font: inherit;
		}

		input {
			width: 100%;
			outline: none;
			border-radius: 7px;
			color: hsl(182, 100%, 35%);
		}

		button {
			cursor: pointer;
		}

		ion-icon {
			pointer-events: none;
		}

		address {
			font-style: normal;
		}

		html {
			font-size: 10px;
			font-family: var(--ff-rubik);
			scroll-behavior: smooth;
		}

		body {
			background-color: var(--white);
			font-size: 1.6rem;
			color: var(--independece);
			line-height: 1.8;
			overflow: hidden;
		}

		body.loaded {
			overflow-y: visible;
		}

		body.nav-active {
			overflow: hidden;
		}

		.container {
			padding-inline: 16px;
		}

		.headline-lg {
			font-size: var(--headline-lg);
			color: var(--white);
			font-weight: var(--fw-500);
			line-height: 1.2;
		}

		.headline-md {
			font-size: var(--headline-md);
			font-weight: var(--fw-700);
		}

		.headline-lg,
		.headline-md {
			font-family: var(--ff-oswald);
		}

		.headline-md,
		.headline-sm {
			line-height: 1.3;
		}

		.headline-md,
		.headline-sm {
			color: var(--midnight-green);
		}

		.headline-sm {
			font-size: var(--headline-sm);
		}

		.title-lg {
			font-size: var(--title-lg);
		}

		.title-md {
			font-size: var(--title-md);
		}

		.title-sm {
			font-size: var(--title-sm);
		}

		.social-list {
			display: flex;
		}

		.section {
			padding-block: var(--section-padding);
		}

		.has-before,
		.has-after {
			position: relative;
			z-index: 1;
		}

		.has-before::before,
		.has-after::after {
			content: "";
			position: absolute;
		}

		.btn {
			background-color: var(--verdigris);
			color: var(--white);
			font-weight: var(--fw-700);
			padding: 12px 36px;
			display: flex;
			align-items: center;
			gap: 8px;
			border-radius: var(--radius-6);
			overflow: hidden;
		}

		.btn::before {
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background-color: var(--eerie-black);
			border-radius: var(--radius-6);
			transition: var(--transition-2);
			z-index: -1;
		}

		.btn:is(:hover, :focus-visible)::before {
			transform: translateX(100%);
		}

		.w-100 {
			width: 100%;
		}

		.grid-list {
			display: grid;
			gap: 40px 28px;
		}

		.text-center {
			text-align: center;
		}

		[data-reveal] {
			opacity: 0;
			transition: var(--transition-2);
		}

		[data-reveal].revealed {
			opacity: 1;
		}

		[data-reveal="bottom"] {
			transform: translateY(50px);
		}

		[data-reveal="bottom"].revealed {
			transform: translateY(0);
		}

		[data-reveal="left"] {
			transform: translateX(-50px);
		}

		[data-reveal="right"] {
			transform: translateX(50px);
		}

		[data-reveal="left"].revealed,
		[data-reveal="right"].revealed {
			transform: translateX(0);
		}

		.preloader {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100vh;
			background-color: var(--verdigris);
			display: grid;
			place-items: center;
			z-index: 6;
			transition: var(--transition-1);
		}

		.preloader.loaded {
			visibility: hidden;
			opacity: 0;
		}

		.preloader .circle {
			width: 50px;
			height: 50px;
			border: 4px solid var(--white);
			border-radius: var(--radius-circle);
			border-block-start-color: transparent;
			animation: rotate360 1s ease infinite;
		}

		@keyframes rotate360 {
			0% {
				transform: rotate(0);
			}

			100% {
				transform: rotate(1turn);
			}
		}

		.header .btn {
			display: block;
		}

		.header {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			padding-block: 16px;
			z-index: 4;
		}

		.header.active {
			position: fixed;
			background-color: var(--rich-black-fogra-29);
			animation: headerActive 0.5s ease forwards;
		}

		@keyframes headerActive {
			0% {
				transform: translateY(-100%);
			}

			100% {
				transform: translateY(0);
			}
		}

		.header .container {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.nav-open-btn {
			color: var(--white);
			font-size: 4rem;
		}

		.navbar,
		.overlay {
			position: fixed;
			top: 0;
			width: 100%;
			height: 100vh;
		}

		.navbar {
			right: -300px;
			max-width: 300px;
			background-color: var(--rich-black-fogra-29);
			z-index: 3;
			transition: 0.25s var(--cubic-in);
			visibility: hidden;
		}

		.navbar.active {
			transform: translateX(-300px);
			visibility: visible;
			transition: 0.5s var(--cubic-out);
		}

		.navbar-top {
			position: relative;
			padding-inline: 25px;
			padding-block: 55px 100px;
		}

		.nav-close-btn {
			position: absolute;
			top: 15px;
			right: 20px;
			color: var(--white);
			font-size: 2.8rem;
		}

		.navbar-list {
			margin-block-end: 30px;
			border-block-end: 1px solid var(--white_a10);
		}

		.navbar-item {
			border-block-start: 1px solid var(--white_a10);
		}

		.navbar-link {
			color: var(--white);
			text-transform: uppercase;
			padding: 10px 24px;
		}

		.social-list {
			justify-content: center;
			gap: 20px;
			color: var(--white);
			font-size: 1.8rem;
		}

		.overlay {
			right: -100%;
			background-color: var(--black);
			opacity: 0.3;
			visibility: hidden;
			transition: var(--transition-2);
			z-index: 2;
		}

		.overlay.active {
			transform: translateX(-100%);
			visibility: visible;
		}

		.hero-banner {
			display: none;
		}

		.hero {
			background-color: var(--midnight-green);
			--section-padding: 200px;
			background-repeat: no-repeat;
			background-size: cover;
		}

		.hero-subtitle {
			color: var(--white);
			font-weight: var(--fw-500);
			padding-inline-start: 80px;
		}

		.hero-subtitle::before {
			top: 50%;
			left: 0;
			width: 60px;
			height: 1px;
			background-color: var(--white);
		}

		.hero-title {
			margin-block: 20px 30px;
		}

		.hero-card {
			background-color: var(--white);
			border-radius: var(--radius-12);
			padding: 20px;
		}

		.hero-card .card-text {
			color: var(--eerie-black);
			border-block-end: 1px solid var(--midnight-green_a25);
			padding-block-end: 12px;
			margin-block-end: 14px;
		}

		.hero-card .input-wrapper {
			position: relative;
		}

		.hero-card .input-field {
			color: var(--eerie-black);
			border-block-end: 1px solid var(--gainsboro);
			padding-inline-end: 18px;
		}

		.hero-card .input-wrapper ion-icon {
			position: absolute;
			top: 50%;
			right: 0;
			transform: translateY(-50%);
			color: var(--verdigris);
		}

		.hero-card .btn {
			width: 100%;
			justify-content: center;
			margin-block-start: 16px;
		}

		.service-list {
			padding-block: 60px 30px;
			padding-inline: 25px;
			display: grid;
			gap: 30px;
			border-radius: var(--radius-12);
			margin-block-start: -60px;
			background-color: var(--white);
			box-shadow: var(--shadow-1);
		}

		.service-card {
			text-align: center;
		}

		.service-card .card-icon,
		.btn-circle {
			max-width: max-content;
			margin-inline: auto;
		}

		.service-card .card-icon {
			margin-block-end: 25px;
		}

		.service-card .card-text {
			margin-block: 20px 15px;
		}

		.service-card .btn-circle {
			color: var(--verdigris);
			font-size: 2rem;
			padding: 18px;
			border-radius: var(--radius-circle);
			box-shadow: var(--shadow-2);
			transition: var(--transition-1);
		}

		.service-card .btn-circle:is(:hover, :focus-visible) {
			background-color: var(--verdigris);
			color: var(--white);
		}

		.about {
			padding-block-end: 0;
		}

		.about .container {
			display: grid;
			gap: 20px;
		}

		.about .section-text {
			margin-block: 20px 35px;
		}

		.tab-list {
			display: flex;
			flex-wrap: wrap;
			gap: 20px 15px;
		}

		.tab-btn {
			background-color: var(--alice-blue);
			color: var(--midnight-green);
			padding: 7px 30px;
			border-radius: var(--radius-6);
			font-weight: var(--fw-700);
		}

		.tab-btn.active {
			background-color: var(--verdigris);
			color: var(--white);
		}

		.tab-text {
			color: var(--midnight-green);
			margin-block: 35px;
		}

		.about-item {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-block-end: 10px;
		}

		.about-item ion-icon {
			color: var(--verdigris);
			font-size: 2rem;
			flex-shrink: 0;
		}

		.listing {
			background-color: var(--alice-blue);
		}

		.listing-card {
			padding: 25px 16px;
			display: flex;
			gap: 20px;
			border: 2px solid var(--middle-blue-green_40);
			border-radius: var(--radius-12);
			transition: var(--transition-1);
		}

		.listing-card:is(:hover, :focus-visible) {
			border-color: var(--verdigris);
		}

		.listing-card .card-title {
			margin-block-end: 5px;
			font-family: var(--ff-oswald);
		}

		.listing-card .card-text {
			color: var(--midnight-green);
		}

		.blog {
			background-image: linear-gradient(to bottom, var(--alice-blue) 90%, var(--white) 10%);
			padding-block-start: 50px;
		}

		/* .blog .section-title {
  margin-block-end: 60px;
} */

		.blog-card {
			padding: 50px 36px;
			border-radius: var(--radius-12);
			border: 2px solid var(--alice-blue);
			/* background-image: url('https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/blog-card.jpg'); */
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
			overflow: hidden;
		}

		.card-1 {
			background-image: url('/img/images/award3.jpg');
		}

		.card-2 {
			background-image: url('/img/images/award1.jpg');'
		}

		.card-3 {
			background-image: url('/img/images/award2.jpg');
		}


		.blog-card::before,
		.blog-card::after {
			inset: 0;
			z-index: -1;
			transition: var(--transition-3);
		}

		.blog-card::before {
			background-color: var(--midnight-green);
			opacity: 0.9;
		}

		.blog-card::after {
			background-color: var(--white);
		}

		.blog-card:is(:hover, :focus-within)::after {
			transform: translateY(100%);
		}

		.blog-card .meta-wrapper {
			display: flex;
			flex-wrap: wrap;
			gap: 5px 20px;
			margin-block-end: 12px;
		}

		.blog-card .card-meta {
			display: flex;
			align-items: center;
			gap: 5px;
			color: var(--midnight-green);
		}

		.blog-card .card-meta ion-icon {
			font-size: 1.8rem;
		}

		.blog-card .card-meta:first-child .span {
			text-transform: uppercase;
		}

		.blog-card .date {
			color: var(--space-cadet);
			font-weight: var(--fw-700);
			text-transform: uppercase;
			opacity: 0.5;
			margin-block: 16px;
		}

		.blog-card .btn-text {
			color: var(--verdigris);
			margin-block-start: 12px;
		}

		.blog-card :is(.card-meta, .card-title, .date, .card-text, .btn-text) {
			transition: var(--transition-2);
		}

		.blog-card:is(:hover, :focus-within) :is(.card-meta, .card-title, .date, .card-text, .btn-text) {
			color: var(--white);
		}

		.footer {
			background-color: var(--midnight-green);
			color: var(--white);
			background-size: contain;
			background-position: top right;
			background-repeat: no-repeat;
		}

		.footer-top {
			display: grid;
			gap: 40px;
			padding-block-end: 60px;
		}

		.footer-brand {
			background-color: var(--ming);
			padding: 32px;
			border-radius: var(--radius-6);
		}

		.footer .logo {
			margin-block-end: 20px;
		}

		.contact-item {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			margin-block-start: 12px;
		}

		.contact-item .item-icon {
			font-size: 4rem;
		}

		.contact-link {
			display: inline;
			transition: var(--transition-1);
		}

		.contact-link:is(:hover, :focus-visible) {
			color: var(--verdigris);
		}

		.footer-list-title {
			color: var(--white);
			font-weight: var(--fw-700);
			margin-block-end: 20px;
		}

		.footer .text {
			opacity: 0.7;
		}

		.footer .address {
			display: flex;
			align-items: center;
			gap: 12px;
			margin-block-start: 20px;
		}

		.footer .address ion-icon {
			font-size: 4rem;
			flex-shrink: 0;
		}

		.footer-link {
			margin-block-start: 8px;
			transition: var(--transition-1);
		}

		.footer-link:is(:hover, :focus-visible) {
			color: var(--verdigris);
		}

		.footer-form .input-field {
			color: var(--white);
			border: 1px solid var(--white_a20);
			border-radius: var(--radius-4);
			padding: 8px 20px;
		}

		.footer-form .input-field::placeholder {
			color: inherit;
		}

		.footer-form .btn {
			width: 100%;
			justify-content: center;
			margin-block: 12px 28px;
		}

		.footer-bottom {
			padding-block: 32px;
			border-block-start: 1px solid var(--white_a20);
		}

		.footer-bottom .social-list {
			justify-content: flex-start;
			gap: 8px;
			margin-block-start: 16px;
		}

		.footer-bottom .social-link {
			font-size: 1.4rem;
			padding: 12px;
			background-color: var(--white_a10);
			border-radius: var(--radius-circle);
			transition: var(--transition-1);
		}

		.footer-bottom .social-link:is(:hover, :focus-visible) {
			background-color: var(--verdigris);
		}

		.back-top-btn {
			position: fixed;
			bottom: 30px;
			right: 30px;
			background-color: var(--verdigris);
			color: var(--white);
			padding: 16px;
			font-size: 2rem;
			border-radius: var(--radius-circle);
			transition: var(--transition-1);
			opacity: 0;
			z-index: 3;
		}

		.back-top-btn:is(:hover, :focus-visible) {
			background-color: var(--eerie-black);
		}

		.back-top-btn.active {
			transform: translateY(-10px);
			opacity: 1;
		}

		@media (min-width: 768px) {

			:root {
				--headline-lg: 8rem;
				--headline-md: 4.8rem;

			}

			.container {
				max-width: 750px;
				width: 100%;
				margin-inline: auto;
			}

			.header .btn {
				display: block;
			}

			.nav-open-btn {
				margin-inline-start: auto;
			}

			.header .container {
				gap: 40px;
			}

			.hero-title {
				line-height: 1.125;
			}

			.hero .wrapper {
				display: flex;
				gap: 16px;
			}

			.hero-card .input-wrapper {
				flex-grow: 1;
			}

			.hero-card .input-field {
				height: 100%;
			}

			.hero-card .btn {
				width: max-content;
				margin-block-start: 0;
			}

			.service-list {
				grid-template-columns: 1fr 1fr;
			}

			.about-list {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
			}

			.about-banner {
				max-width: max-content;
				margin-inline: auto;
			}

			.listing .grid-list {
				grid-template-columns: 1fr 1fr;
			}

			.listing .grid-list>li:first-child {
				grid-column: 1 / 3;
			}

			.footer-top {
				grid-template-columns: 1fr 1fr;
			}

			.footer-brand {
				grid-column: 1 / 3;
			}

			.contact-list {
				display: flex;
				flex-wrap: wrap;
				align-items: center;
				gap: 24px;
			}

			.footer-bottom {
				display: flex;
				justify-content: space-between;
				align-items: center;
			}

			.footer-bottom .social-list {
				margin-block-start: 0;
			}

		}

		@media (min-width: 992px) {

			.container {
				max-width: 940px;
			}

			.hero-banner {
				display: block;
				max-width: max-content;
			}

			.hero .container {
				display: grid;
				grid-template-columns: 1fr 1fr;
				align-items: center;
			}

			.service-list {
				grid-template-columns: repeat(4, 1fr);
			}

			.about .container {
				grid-template-columns: 1fr 0.8fr;
				align-items: flex-end;
			}

			.about-content {
				padding-block-end: var(--section-padding);
			}

			.about-banner {
				margin-inline-end: -80px;
			}

			.blog .grid-list {
				grid-template-columns: 1fr 1fr;
			}

		}

		@media (min-width: 1200px) {
			.container {
				max-width: 1200px;
			}

			.header {
				padding-block: 24px;
			}

			.nav-open-btn,
			.overlay,
			.navbar-top,
			.navbar .social-list {
				display: none;
			}

			.navbar,
			.navbar.active,
			.navbar-list {
				all: unset;
				display: block;
			}

			.navbar {
				margin-inline-start: auto;
			}

			.navbar-list {
				display: flex;
				gap: 8px;
			}

			.navbar-item {
				border-block-start: none;
			}

			.navbar-link {
				--title-md: 1.8rem;
				font-weight: var(--fw-500);
				padding-inline: 16px;
				text-transform: capitalize;
			}

			.hero .container {
				grid-template-columns: 0.8fr 1fr;
				gap: 96px;
			}

			.listing .grid-list {
				grid-template-columns: repeat(4, 1fr);
			}

			.blog .grid-list {
				grid-template-columns: repeat(3, 1fr);
			}

			.footer {
				background-size: auto;
			}

			.footer-top {
				grid-template-columns: repeat(4, 1fr);
			}

			.footer-brand {
				grid-column: 1 / 5;
				padding: 28px 56px;
				display: grid;
				grid-template-columns: 0.3fr 1fr;
				align-items: center;
			}

			.footer .logo {
				margin-block-end: 0;
			}

			.contact-list {
				justify-content: space-between;
			}

			.contact-list::after {
				top: 0;
				left: 50%;
				width: 2px;
				height: 100%;
				background-color: var(--white_a20);
			}

			.contact-item {
				margin-block-start: 0;
			}
		}

		/* Add this to your CSS file */

		/* Desktop Dropdown Styles */
		@media (min-width: 1200px) {
			.has-dropdown {
				position: relative;
			}

			.navbar-link .dropdown-icon {
				font-size: 1.2rem;
				margin-left: 5px;
				transition: transform 0.3s;
			}

			.has-dropdown:hover .dropdown-icon {
				transform: rotate(180deg);
			}

			.dropdown-menu {
				position: absolute;
				top: 100%;
				left: 0;
				min-width: 220px;
				background-color: var(--white);
				padding: 15px 0;
				box-shadow: var(--shadow-1);
				border-radius: var(--radius-6);
				opacity: 0;
				visibility: hidden;
				transform: translateY(20px);
				transition: all 0.3s ease;
			}

			.has-dropdown:hover>.dropdown-menu {
				opacity: 1;
				visibility: visible;
				transform: translateY(0);
			}

			.dropdown-link {
				color: var(--midnight-green);
				font-size: 1.6rem;
				padding: 8px 24px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				transition: color 0.3s;
			}

			.dropdown-link:hover {
				color: var(--verdigris);
				background-color: var(--alice-blue);
			}

			/* Submenu Styles */
			.has-submenu {
				position: relative;
			}

			.submenu {
				position: absolute;
				left: 100%;
				top: 0;
				min-width: 220px;
				background-color: var(--white);
				padding: 15px 0;
				box-shadow: var(--shadow-1);
				border-radius: var(--radius-6);
				opacity: 0;
				visibility: hidden;
				transform: translateX(20px);
				transition: all 0.3s ease;
			}

			.has-submenu:hover>.submenu {
				opacity: 1;
				visibility: visible;
				transform: translateX(0);
			}

			.submenu-link {
				color: var(--midnight-green);
				font-size: 1.6rem;
				padding: 8px 24px;
				display: block;
				transition: color 0.3s;
			}

			.submenu-link:hover {
				color: var(--verdigris);
				background-color: var(--alice-blue);
			}
		}

		/* Mobile Dropdown Styles */
		@media (max-width: 1200px) {

			.dropdown-menu,
			.submenu {
				display: none;
				padding-left: 20px;
			}

			.dropdown-menu.active,
			.submenu.active {
				display: block;
			}

			.navbar-link,
			.dropdown-link {
				display: flex;
				justify-content: space-between;
				align-items: center;
			}

			.dropdown-icon,
			.submenu-icon {
				font-size: 1.8rem;
				transition: transform 0.3s;
			}

			.dropdown-icon.active,
			.submenu-icon.active {
				transform: rotate(180deg);
			}

			.dropdown-link,
			.submenu-link {
				color: var(--white);
				padding: 8px 24px;
				display: block;
			}

			.submenu {
				border-left: 1px solid var(--white_a20);
			}
		}
	</style>

	<style>
		/* Modal styling */
		.modal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			z-index: 9999;
			justify-content: center;
			align-items: center;
		}

		.modal-content {
			background: var(--white);
			padding: 20px;
			width: 90%;
			max-width: 400px;
			border-radius: var(--radius-12);
			box-shadow: var(--shadow-1);
			position: relative;
			text-align: center;
		}

		.modal-content h2 {
			margin-bottom: 20px;
		}

		.close-btn {
			position: absolute;
			top: 10px;
			right: 10px;
			font-size: 24px;
			cursor: pointer;
			color: var(--eerie-black);
		}


@media (max-width: 768px){
    .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: var(--white);
    padding: 10px; /* Reduced padding */
    width: 80%; /* Adjust width */
    max-width: 300px; /* Reduced max-width */
    border-radius: var(--radius-6); /* Smaller border radius */
    box-shadow: var(--shadow-1);
    position: relative;
    text-align: center;
}

.modal-content h2 {
    margin-bottom: 15px; /* Reduced margin */
    font-size: 1.6rem; /* Smaller font size */
}

.close-btn {
    position: absolute;
    top: 5px; /* Adjusted position */
    right: 5px; /* Adjusted position */
    font-size: 18px; /* Reduced font size */
    cursor: pointer;
    color: var(--eerie-black);
}
}

		/* Mobile Dropdown Styles */
		@media (max-width: 1200px) {
			.navbar {
				max-height: 100vh;
				/* Ensure it doesn't overflow the viewport */
				overflow-y: auto;
				/* Enable vertical scrolling */
			}

			.navbar-list {
				max-height: 75vh;
				/* Limit the height of the list */
				overflow-y: auto;
				/* Enable scrolling for long menus */
				padding-right: 10px;
				/* Add some padding for scrollbar spacing */
			}

			.dropdown-menu,
			.submenu {
				max-height: 50vh;
				/* Ensure dropdowns don't exceed the viewport */
				overflow-y: auto;
				/* Add scrolling for dropdowns */
			}
		}

		.navbar-list {
			position: relative;
			
		}
	</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>


</head>

<body id="top">
	<div class="preloader" data-preloader>
		<div class="circle"></div>
	</div>

	<header class="header" data-header>
		<div class="container">
			<a href="#" class="logo">
			  

				<img src="/img/images/logo.jpg" width="136" height="46" alt="Doclab home">
			</a>
			<nav class="navbar" data-navbar>
				<div class="navbar-top">
					<a href="#" class="logo">
						<img src="/img/images/logo.jpg"
							width="136" height="46" alt="Doclab home">
					</a>
					<button class="nav-close-btn" aria-label="clsoe menu" data-nav-toggler>
						<ion-icon name="close-outline" aria-hidden="true"></ion-icon>
					</button>
				</div>
				<!-- Replace the existing navbar-list with this -->
				<ul class="navbar-list">
					<li class="navbar-item">
						<a href="#" class="navbar-link title-md">Home</a>
					</li>

					<li class="navbar-item has-dropdown">
						<a href="#" class="navbar-link title-md">Solutions <ion-icon name="chevron-down-outline"
								class="dropdown-icon"></ion-icon></a>
						<ul class="dropdown-menu">

							<li class="has-submenu">
								<a href="#" class="dropdown-link">Ambulatory Solutions <ion-icon
										name="chevron-forward-outline" class="submenu-icon"></ion-icon></a>
								<ul class="submenu">
									<li>
										<?php echo $this->Html->link('Patient Portal', array('controller' => 'pages', 'action' => 'patient_portal'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Ambulatory EMR', array('controller' => 'pages', 'action' => 'ambulatory_emr'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
								</ul>
							</li>

							<li class="has-submenu">
								<a href="#" class="dropdown-link">Hopital Solutions <ion-icon
										name="chevron-forward-outline" class="submenu-icon"></ion-icon></a>
								<ul class="submenu">
									<li>
										<?php echo $this->Html->link('Hospital Information Management', array('controller' => 'pages', 'action' => 'hosptal_info_manage'), array('class' => 'submenu-link', 'escape' => false)); ?>

									</li>
									<li>
										<?php echo $this->Html->link('Inpatient EMR', array('controller' => 'pages', 'action' => 'impatient_emr'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
								</ul>
							</li>

							<li class="has-submenu">
								<a href="#" class="dropdown-link">Public Sector Solutions <ion-icon
										name="chevron-forward-outline" class="submenu-icon"></ion-icon></a>
								<ul class="submenu">
									<li> <?php echo $this->Html->link('Public Health', array('controller' => 'pages', 'action' => 'public_health'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li> <?php echo $this->Html->link('Telemedecine', array('controller' => 'pages', 'action' => 'telemedecine'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li><a href="#" class="submenu-link">Dentistry</a></li>
								</ul>
							</li>

							<li class="has-submenu">
								<a href="#" class="dropdown-link">Specility Solutions <ion-icon
										name="chevron-forward-outline" class="submenu-icon"></ion-icon></a>
								<ul class="submenu">
									<li>
										<?php echo $this->Html->link('OT Scheduling and Management', array('controller' => 'pages', 'action' => 'ot_s_m'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Dental', array('controller' => 'pages', 'action' => 'dental'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Physiotherapy', array('controller' => 'pages', 'action' => 'physio'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Obestrics/Gynacology', array('controller' => 'pages', 'action' => 'obest_gyna'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Opthalmology', array('controller' => 'pages', 'action' => 'opth'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Oncology', array('controller' => 'pages', 'action' => 'oncology'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
									<li>
										<?php echo $this->Html->link('Cardiology', array('controller' => 'pages', 'action' => 'cardio'), array('class' => 'submenu-link', 'escape' => false)); ?>
									</li>
								</ul>
							</li>

							<li>
								<?php echo $this->Html->link('EHR Software', array('controller' => 'pages', 'action' => 'ehr-software'), array('class' => 'submenu-link', 'escape' => false)); ?>
							</li>
						</ul>
					</li>

					<li class="navbar-item has-dropdown">
						<a href="#" class="navbar-link title-md">Services <ion-icon name="chevron-down-outline"
								class="dropdown-icon"></ion-icon></a>
						<ul class="dropdown-menu">
							<li>
								<?php echo $this->Html->link(
									'Consulting and Implementations',
									array('controller' => 'pages', 'action' => 'consulting_implement'),
									array('class' => 'submenu-link', 'escape' => false)
								); ?>
							</li>
							<li>
								<?php echo $this->Html->link(
									'Healthcare IT Services',
									array('controller' => 'pages', 'action' => 'healthcare_itservice'),
									array('class' => 'submenu-link', 'escape' => false)
								); ?>
							</li>
							<li>
								<?php echo $this->Html->link(
									'Healthcare Application Training Services',
									array('controller' => 'pages', 'action' => 'hats'),
									array('class' => 'submenu-link', 'escape' => false)
								); ?>
							</li>
							<li>
								<?php echo $this->Html->link(
									'Infrastructure Support Services',
									array('controller' => 'pages', 'action' => 'infra_support'),
									array('class' => 'submenu-link', 'escape' => false)
								); ?>
							</li>
						</ul>
					</li>

					<li class="navbar-item has-dropdown">
						<a href="#" class="navbar-link title-md">Benefits <ion-icon name="chevron-down-outline"
								class="dropdown-icon"></ion-icon></a>
						<ul class="dropdown-menu">
						<li class="has-submenu">
								<a href="#" class="dropdown-link">Innovetions<ion-icon name="chevron-forward-outline"
										class="submenu-icon"></ion-icon></a>
								<ul class="submenu">
									<li>
										<a class="submenu-link"
											href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'adverse_events']); ?>">Adverse
											event</a>
									</li>
									<li>
										<a class="submenu-link"
											href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'support_portal']); ?>">Support
											portal</a>
									</li>
									<li>
										<a class="submenu-link"
											href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'language_interpreters']); ?>">Language
											interpreter video/voice</a>
									</li>
									<li>
										<a class="submenu-link"
											href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'smartroom']); ?>">Smartest
											room</a>
									</li>
									<li>
										<a class="submenu-link"
											href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'vap_monitor']); ?>">VAP
											quality monitor</a>
									</li>
									<li>
										<a class="dropdown-link"
											href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'dshbrd']); ?>">Dashboards</a>
									</li>
								</ul>
							</li>

							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'free_emr']); ?>">Free
									EMR</a>
							</li>
							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'web_based']); ?>">Web
									Based</a>
							</li>
							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'earn_money']); ?>">Earn
									stimulus money</a>
							</li>
							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'emr-software']); ?>">EMR
									Software</a>
							</li>
							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'stay_secure']); ?>">Stay
									secure</a>
							</li>
							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'emr_comparison']); ?>">EMR
									Comparison</a>
							</li>
							<li>
								<a class="submenu-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'support']); ?>">Unlimited
									Support</a>
							</li>

						</ul>
					</li>



					<li class="navbar-item has-dropdown">
						<a href="#" class="navbar-link title-md">Company <ion-icon name="chevron-down-outline"
								class="dropdown-icon"></ion-icon></a>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'comp_awards_certi']); ?>">Awards
									and Events</a>
							</li>
							<li>
								<a class="dropdown-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'certification']); ?>">Certifications</a>
							</li>
							<li>
								<a class="dropdown-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'faq']); ?>">FAQ</a>
							</li>
							<li>
								<a class="dropdown-link"
									href="<?php echo $this->Html->url(['controller' => 'pages', 'action' => 'story_so_far']); ?>">Story
									So Far</a>
							</li>
						</ul>
					</li>

				

					
				</ul>
				<ul class="social-list">
					<li>
						<a href="http://www.twitter.com/DrMHope" class="social-link">
							<ion-icon name="logo-twitter"></ion-icon>
						</a>
					</li>
					<li>
						<a href="http://www.facebook.com/drmhopeCLOUD" class="social-link">
							<ion-icon name="logo-facebook"></ion-icon>
						</a>
					</li>
					<li>
						<a href="mailto:info@drmhope.com" class="social-link">
							<ion-icon name="mail"></ion-icon>
						</a>
					</li>
					<li>
						<a href="https://plus.google.com/101489643999327172156" class="social-link">
							<ion-icon name="logo-google"></ion-icon>
						</a>
					</li>
					<li>
						<a href="http://www.youtube.com/drmhopedemos" class="social-link">
							<ion-icon name="logo-youtube"></ion-icon>
						</a>
					</li>
				</ul>
			</nav>
			<a href="#" class="btn has-before title-md">Sign In</a>

			<button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
				<ion-icon name="menu-outline"></ion-icon>
			</button>
			<div class="overlay" data-nav-toggler data-overlay></div>
		</div>
	</header>

	<main>
		<article>
			<section class="section hero"
				style="background-image: url('https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/hero-bg.png')"
				aria-label="home">
				<div class="container">
					<div class="hero-content">
						<p class="hero-subtitle has-before" data-reveal="left">Welcome To DrMhope</p>
						<h1 class="headline-lg hero-title" data-reveal="left">
							A Reliable Hospital<br>
							Management Solution.
						</h1>

					</div>
					<figure class="hero-banner" data-reveal="right">
						<img src="https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/hero-banner.png"
							width="590" height="517" loading="eager" alt="hero banner" class="w-100">
					</figure>
				</div>
			</section>

			<section class="service" aria-label="service">
				<div class="container">
					<ul class="service-list">
						<li>
							<div class="service-card" data-reveal="bottom">
								<div class="card-icon">
									<img src="https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/icon-3.png" width="71" height="71" loading="lazy"
										alt="icon">
								</div>
								<h3 class="headline-sm card-title">
									Orthopedics
								</h3>
							

							</div>
						</li>
						<li>
							<div class="service-card" data-reveal="bottom">
								<div class="card-icon">
									<img src="https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/icon-4.png"
										width="71" height="71" loading="lazy" alt="icon">
								</div>
								<h3 class="headline-sm card-title">
									<a href="#">Cardiology</a>
								</h3>
							
							</div>
						</li>

						<li>
							<div class="service-card" data-reveal="bottom">
								<div class="card-icon">
									<img src="https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/icon-1.png" width="71" height="71" loading="lazy"
										alt="icon">
								</div>
								<h3 class="headline-sm card-title">
									<a href="#">Neurology</a>
								</h3>
								

							</div>
						</li>
						<li>
							<div class="service-card" data-reveal="bottom">
								<div class="card-icon">
									<img src="https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/icon-2.png" width="71" height="71" loading="lazy"
										alt="icon">
								</div>
								<h3 class="headline-sm card-title">
									<a href="#">Gastrology</a>
								</h3>
							

							</div>
						</li>
					</ul>
				</div>
			</section>

			<section class="section about" aria-labelledby="about-label">
				<div class="container">
					<div class="about-content">

						<h2 class="headline-md" data-reveal="left">About Us</h2>
						<p class="section-text" data-reveal="left">
							DrMhope, A Reliable Hospital Management Solution
							Award Winning, ISO 9001:2008 Certified, HIPAA Compliant Hospital Management Software
							DrMHope is one of the first Saas based ENTERPRIZE LEVEL Hospital Management Information
							Software,registered for patients in US & India for Hospital Information Systems. It will
							change the way your doctors, clinicians, and medical staff share patient information.
							DrMHope is patented, subscription based application certified & tested under the ONC HIT
							Certificate Program 2014 edition certification criteria (USA) for both ambulatory and
							inpatient.
							This SaaS based Cloud Hospital management System for both Ambulatory and Inpatient will
							enhance your hospital`s, Patient-care management, improve patient safety, reduce cost, a few
							notches higher; enhancing overall productivity of your hospital and patient`s clinical
							experience.Employee Management, Billing & Administration.
							Aimed at the Critical Care facilities, DrM EMR & EHR is the answer to all your HMS problems.
							Family clinics and General practioners will love our easy to use Ambulatory EMR.
						</p>

						<div class="wrapper">
							<ul class="about-list">
								<li class="about-item" data-reveal="left">
									<ion-icon name="checkmark-circle-outline"></ion-icon>
									<span class="span">Seamless Data Management</span>
								</li>
								<li class="about-item" data-reveal="left">
									<ion-icon name="checkmark-circle-outline"></ion-icon>
									<span class="span">Real-Time Collaboration Across Departments</span>
								</li>
								<li class="about-item" data-reveal="left">
									<ion-icon name="checkmark-circle-outline"></ion-icon>
									<span class="span">AI-Powered System</span>
								</li>
								<li class="about-item" data-reveal="left">
									<ion-icon name="checkmark-circle-outline"></ion-icon>
									<span class="span">Enhanced User Experience</span>
								</li>
							</ul>
						</div>
					</div>
					<figure class="about-banner" data-reveal="right">
						<img src="https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/about-banner.png"
							width="554" height="678" loading="lazy" alt="about banner" class="w-100">
					</figure>
				</div>
			</section>


			<section class="section blog" aria-labelledby="blog-label">
				<div class="container">
					<!-- <p class="section-subtitle title-lg text-center" id="blog-label" data-reveal="bottom">
			News & Article
		  </p> -->
					<h2 class="section-title headline-md text-center" data-reveal="bottom">Awards</h2>
					<br>
					<ul class="grid-list">
						<li>
							<div class="blog-card has-before has-after card-1" data-reveal="bottom">
								<h3 class="headline-sm card-title">Mark of Excellence</h3><br>
								<p class="card-text">
									Awarded the "Mark of Excellence" by the National Accreditation Board for Hospitals
									and Healthcare providers on 19th December 2012. Assessed and found to comply with
									NABH accreditation requirements for hospitals.
								</p>
								<br>
								<br>
							</div>
						</li>
						<li>
							<div class="blog-card has-before has-after card-2" data-reveal="bottom">
								<h3 class="headline-sm card-title">IIGP awards 2013</h3> <br>
								<p class="card-text">
									Gold Medal Winner of the IIGP awards 2013(India Innovation Growth Programme) from
									1500 innovative technology entries.
								</p>
								<br>
								<br>
								<br>
								<br>
								<br>
							</div>
						</li>
						<li>
							<div class="blog-card has-before has-after card-2" data-reveal="bottom">
								<h3 class="headline-sm card-title">Pilot project was at Hope Hospital</h3> <br>
								<p class="card-text">
									The pilot project was at Hope Hospital, which went onto acquire NABH accreditation
									within a short period of two years. Hope Hospitals is an ISO 9001-2008 certified and
									NABH accredited private hospital. It is the first Nagpur based multi-specialist
									hospital to be accredited by NABH.
								</p>

							</div>
						</li>
					</ul>
				</div>
			</section>
		</article>
	</main>

	<footer class="footer"
		style="background-image: url('https://raw.githubusercontent.com/farazc60/Project-Images/main/medical/assets/footer-bg.png')">
		<div class="container">
			<div class="section footer-top">
				<div class="footer-brand" data-reveal="bottom">
					<a href="#" class="logo">
						<img src="/img/images/logo.jpg" width="136" height="46" loading="lazy" alt="Doclab home">
					</a>
					<ul class="contact-list has-after">
						<li class="contact-item">
							<div class="item-icon">
								<ion-icon name="mail-open-outline"></ion-icon>
							</div>
							<div>
								<p>
									Email : <a href="mailto:info@drmhope.com  "
										class="contact-link">info@drmhope.com</a>
								</p>
							</div>
						</li>
						<li class="contact-item">
							<div class="item-icon">
								<ion-icon name="call-outline"></ion-icon>
							</div>
							<div>
								<p>
									Contact No.: <a href="tel:18002330000" class="contact-link">18002330000</a>
								</p>
							</div>
						</li>
					</ul>
				</div>
				<div class="footer-list" data-reveal="bottom">
					<p class="headline-sm footer-list-title">Certifications</p>
					<p>
						<img src="https://hopesoftwares.com/img/onc-ambulatory.png" alt="">
					</p>
					<p>
						<img src="https://hopesoftwares.com/img/onc-inpatient.png" alt="">
					</p>
				</div>
				<ul class="footer-list" data-reveal="bottom">
					<li>
						<p class="headline-sm footer-list-title">Address</p>

						Beside Gogas Auto LPG, 2, Kamptee Rd, Nagpur, Maharashtra 440017
					</li>
				</ul>
				<ul class="footer-list" data-reveal="bottom">
					<li>
						<p class="headline-sm footer-list-title">Brochure</p>
					</li>
				<a href="http://drmhope.com/downloads/brochure-drmhope.pdf" title="Download Brochure" target="_blank">
							<?php echo $this->Html->image('btn-download.png'); ?>
					</a>
				</ul>
				
			</div>
			<div class="footer-bottom">
				<p class="text copyright">
					DrMHope | Version 2.0
				</p>
				<ul class="social-list">
					<li>
						<a href="http://www.facebook.com/drmhopeCLOUD" class="social-link">
							<ion-icon name="logo-facebook"></ion-icon>
						</a>
					</li>
					<li>
						<a href="http://www.twitter.com/DrMHope" class="social-link">
							<ion-icon name="logo-twitter"></ion-icon>
						</a>
					</li>
					<li>
						<a href="mailto:info@drmhope.com" class="social-link">
							<ion-icon name="mail"></ion-icon>
						</a>
					</li>
					<li>
						<a href="https://plus.google.com/101489643999327172156" class="social-link">
							<ion-icon name="logo-google"></ion-icon>
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</footer>


	<!-- Sign In Modal -->
	<!-- Sign In Modal -->
	<div class="modal" id="signinModal">
		<div class="modal-content">
			<span class="close-btn" id="closeModal">&times;</span>
			<h2>Sign In</h2>
			<div id="loginBox">
				<?php echo $this->Form->create('User', array('id' => 'loginForm', 'action' => 'login')); ?>
				<div style="padding-left: 12px;">Access your SaaS Business System.</div>
				
					
						<label><strong>Username / Patient ID</strong></label>
						<?php echo $this->Form->input('username', array('class' => 'validate[required,custom[mandatory-enter]]', 'div' => false, 'label' => false)); ?>
				

						<label><strong>Password</strong></label>
						<?php echo $this->Form->input('password', array('class' => 'validate[required,custom[mandatory-enter]]', 'div' => false, 'label' => false)); ?>
					
					<div style="display:flex;flex-direction:row;margin-bottom:10px;">
						<input type="checkbox" id="login_as_patient" name="login_as_patient"
							style="width:12px;height:12px;margin-top:9px" />
						<label for="login_as_patient"><strong>Login as patient</strong></label>
					</div>
					<input type="submit" id="login" value="Sign In" />
					<div>
					<a href="#" id="forgot" title="Forgot Password">Forgot Password!</a>
						
					</div>
				
				<input type="hidden" name="client_time_zone" id="client_time_zone" />
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>



	<a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
		<ion-icon name="chevron-up"></ion-icon>
	</a>
	<script src="script.js"></script>
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


	<script>
		'use strict';

		const addEventOnElements = function (elements, eventType, callback) {
			for (let i = 0, len = elements.length; i < len; i++) {
				elements[i].addEventListener(eventType, callback);
			}
		}

		const preloader = document.querySelector("[data-preloader]");

		window.addEventListener("load", function () {
			preloader.classList.add("loaded");
			document.body.classList.add("loaded");
		});

		const navbar = document.querySelector("[data-navbar]");
		const navTogglers = document.querySelectorAll("[data-nav-toggler]");
		const overlay = document.querySelector("[data-overlay]");

		const toggleNav = function () {
			navbar.classList.toggle("active");
			overlay.classList.toggle("active");
			document.body.classList.toggle("nav-active");
		}

		addEventOnElements(navTogglers, "click", toggleNav);

		const header = document.querySelector("[data-header]");
		const backTopBtn = document.querySelector("[data-back-top-btn]");

		const activeElementOnScroll = function () {
			if (window.scrollY > 100) {
				header.classList.add("active");
				backTopBtn.classList.add("active");
			} else {
				header.classList.remove("active");
				backTopBtn.classList.remove("active");
			}
		}

		window.addEventListener("scroll", activeElementOnScroll);

		const revealElements = document.querySelectorAll("[data-reveal]");

		const revealElementOnScroll = function () {
			for (let i = 0, len = revealElements.length; i < len; i++) {
				if (revealElements[i].getBoundingClientRect().top < window.innerHeight / 1.15) {
					revealElements[i].classList.add("revealed");
				} else {
					revealElements[i].classList.remove("revealed");
				}
			}
		}

		window.addEventListener("scroll", revealElementOnScroll);

		window.addEventListener("load", revealElementOnScroll);

		// Add this to your existing JavaScript file

		// Handle Mobile Dropdowns
		const dropdownLinks = document.querySelectorAll('.has-dropdown > .navbar-link, .has-submenu > .dropdown-link');

		dropdownLinks.forEach(link => {
			link.addEventListener('click', function (e) {
				e.preventDefault();

				// Toggle dropdown/submenu
				const dropdownMenu = this.nextElementSibling;
				const dropdownIcon = this.querySelector('.dropdown-icon, .submenu-icon');

				// Close other dropdowns at same level
				const siblings = [...this.parentElement.parentElement.children];
				siblings.forEach(sibling => {
					if (sibling !== this.parentElement) {
						const siblingDropdown = sibling.querySelector('.dropdown-menu, .submenu');
						const siblingIcon = sibling.querySelector('.dropdown-icon, .submenu-icon');
						if (siblingDropdown) {
							siblingDropdown.classList.remove('active');
						}
						if (siblingIcon) {
							siblingIcon.classList.remove('active');
						}
					}
				});

				// Toggle current dropdown
				dropdownMenu.classList.toggle('active');
				if (dropdownIcon) {
					dropdownIcon.classList.toggle('active');
				}
			});
		});

		// Close dropdowns when clicking outside
		document.addEventListener('click', function (e) {
			if (window.innerWidth >= 1200) {  // Only for desktop view
				if (!e.target.closest('.has-dropdown')) {
					const dropdowns = document.querySelectorAll('.dropdown-menu, .submenu');
					dropdowns.forEach(dropdown => {
						dropdown.classList.remove('active');
					});
				}
			}
		});
	</script>


	<script>
		// sign in modal code:
		const signinModal = document.getElementById('signinModal');
		const closeModalBtn = document.getElementById('closeModal');
		const signinBtn = document.querySelector('.btn.has-before.title-md'); // "Sign In" button

		// Open modal on Sign In button click
		signinBtn.addEventListener('click', function (e) {
			e.preventDefault(); // Prevent default link action
			signinModal.style.display = 'flex';
		});

		// Close modal on close button click
		closeModalBtn.addEventListener('click', function () {
			signinModal.style.display = 'none';
		});

		// Close modal when clicking outside the modal content
		window.addEventListener('click', function (e) {
			if (e.target === signinModal) {
				signinModal.style.display = 'none';
			}
		});

	</script>
<script>
   jQuery(document).ready(function () {
       // Initialize form validation
    //    jQuery("#loginForm").validationEngine();
    //    jQuery("#contactUsFrm").validationEngine();

       // Forgot password click event
       jQuery('#forgot').click(function (e) {
           e.preventDefault(); // Prevent default link behavior
           jQuery.fancybox.open({
               src: '<?php echo $this->Html->url(["controller" => "home", "action" => "password_recovery"]); ?>',
               type: 'iframe',
               opts: {
                   width: '60%',
                   height: '60%',
                   autoScale: true,
                   transitionEffect: 'fade',
               },
           });
       });
   });
</script>



</body>



</html>