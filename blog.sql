CREATE DATABASE if NOT EXISTS blog;

CREATE TABLE users (
	 id INT AUTO_INCREMENT PRIMARY KEY,
	 username VARCHAR(255) NOT NULL,
	 password VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
   id INT AUTO_INCREMENT PRIMARY KEY,
   name varchar(255) NOT NULL
);

CREATE TABLE posts (
	id INT AUTO_INCREMENT PRIMARY KEY,
	titre VARCHAR(255) NOT NULL,
	image VARCHAR(500) NOT NULL,
	contenu VARCHAR(255),
	categorie_id INT NOT NULL,
	FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

INSERT INTO categories (id, name) VALUES (1, 'Chalets'), (2, 'Camping'), (3, 'Hotels');

INSERT INTO posts (id, titre, image, categorie_id, contenu)
VALUES 
(1, 'Le charme des chalets de montagne', 'https://www.wausauhomes.com/pub/media/wysiwyg/Birch.jpg', 1, 'Profitez d''une expérience inoubliable dans nos confortables chalets de montagne...'),
(2, 'La vie au grand air : camping nature', 'https://lp-cms-production.imgix.net/2020-11/wildcamping.jpg?auto=compress&fit=crop&format=auto&q=50&w=1200&h=800', 2, 'Vivez une aventure en plein air avec nos équipements de camping de pointe...'),
(3, 'Le luxe à portée de main avec nos hôtels 5 étoiles', 'https://images.bubbleup.com/width1920/quality35/mville2017/1-brand/1-margaritaville.com/gallery-media/220803-compasshotel-medford-pool-73868-1677873697.jpg', 3, 'Découvrez le summum du confort et du service avec nos hôtels 5 étoiles...'),
(4, 'Chalets de montagne: une évasion de la vie urbaine', 'https://cdn.lecollectionist.com/lc/production/uploads/photos/house-3703/2020-07-03-f0f9fe40e72395b9e2ea663c892c324a.jpg?q=65', 1, 'Vivez la vie rurale dans nos chalets confortables nichés dans des paysages montagneux idylliques...'),
(5, 'Camping d''hiver : une aventure à essayer', 'https://www.mountaineers.org/blog/snow-camping-101-an-ode-to-the-cold/@@images/image', 2, 'Vivez l''excitation du camping en hiver et embrassez l''aventure...'),
(6, 'Profitez du confort urbain dans nos hôtels de ville', 'https://www.fodors.com/wp-content/uploads/2022/10/Aramness_120.jpeg', 3, 'Découvrez le confort et la commodité avec nos hôtels situés au cœur des centres-villes animés...'),
(7, 'Le temps de s''exiler en nature', 'https://s3.amazonaws.com/imagescloud/images/medias/camping/canot-camping.jpg', 2, 'Ne manquez pas');

SELECT * FROM categories;