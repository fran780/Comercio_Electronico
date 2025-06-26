INSERT INTO `products` (`productId`, `productName`, `productDescription`, `productPrice`, `productImgUrl`, `productStatus`) VALUES
(1, 'Negocios Web Intro', 'Libro de Introducción a los Negocios Web 70 pg', 200, 'https://placehold.co/290x250?text=Negocios-Web-Intro&font=roboto','ACT'),
(2, 'Negocios Web 2', 'Libro de Negocios Web 2 POO 120 pg', 300, 'https://placehold.co/290x250?text=Negocios-Web-2&font=roboto','ACT'),
(3, 'Negocios Web Advance', 'Libro de Negocios Web Ingreso Pasivo 170 pg', 700, 'https://placehold.co/290x250?text=Negocios-Web-Advance&font=roboto','ACT'),
(4, 'Negocios Web Full', 'Libro de Negocios Web Full Stack 220 pg', 1000, 'https://placehold.co/290x250?text=Negocios-Web-Full&font=roboto','ACT'),
(5, 'Negocios Web Master', 'Libro de Negocios Web Master 300 pg', 1500, 'https://placehold.co/290x250?text=Negocios-Web-Master&font=roboto','ACT'),
(6, 'Negocios Web Expert', 'Libro de Negocios Web Expert 400 pg', 2000, 'https://placehold.co/290x250?text=Negocios-Web-Expert&font=roboto','ACT'),
(7, 'Negocios Web Guru', 'Libro de Negocios Web Guru 500 pg', 2500, 'https://placehold.co/290x250?text=Negocios-Web-Guru&font=roboto','ACT'),
(8, 'Negocios Web Master Ninja', 'Libro de Negocios Web Master Ninja 300 pg', 1500, 'https://placehold.co/290x250?text=Negocios-Web-Master-Ninja&font=roboto','ACT'),
(9, 'Negocios Web Expert Ninja', 'Libro de Negocios Web Expert Ninja 400 pg', 2000, 'https://placehold.co/290x250?text=Negocios-Web-Expert-Ninja&font=roboto','ACT'),
(10, 'Negocios Web Guru Ninja', 'Libro de Negocios Web Guru Ninja 500 pg', 2500, 'https://placehold.co/290x250?text=Negocios-Web-Guru-Ninja&font=roboto','ACT');

INSERT INTO `sales` (`saleId`, `productId`, `salePrice`, `saleStart`, `saleEnd`) VALUES
(1, 3, 500, '2025-06-01 00:00:00', '2025-12-31 23:59:59'),
(2, 5, 750, '2025-06-01 00:00:00', '2025-12-31 23:59:59'),
(3, 7, 1500, '2025-06-01 00:00:00', '2025-12-31 23:59:59');

INSERT INTO `highlights` (`highlightId`, `productId`, `highlightStart`, `highlightEnd`) VALUES
(1, 1, '2025-06-01 00:00:00', '2025-12-31 23:59:59'),
(2, 4, '2025-06-01 00:00:00', '2025-12-31 23:59:59');
