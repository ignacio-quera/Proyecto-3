# Entrega 3 Bases De Datos

## Consideraciones generales

Para hacer la importación de usuarios, se utilizó un archivo php llamado ``importar_usuarios`` que se encuentra en la carpeta _funciones_ dentro de _Sites_. Al ingresar a la página se pide introducir un nombre de usuario y una contraseña, dependiendo del tipo de usuario que quiere logearse. Estos se encuentran en una tabla ubicada más abajo en la sección _Usuarios y Contraseñas_. A continuación se hará una descripción detallada de cómo se generaron las contraseñas para cada tipo de usuario.

* **Usuario Admin**:
    * **¿Cómo se asignó la contraseña?**: Se asigna por enunciado.

* **Usuarios Compañía Aerea**:
    * **¿Cómo se asignaron las contraseñas?**: Para generar estas contraseñas, se generó una cadena de 4 bytes aleatoria y luego estos fueron pasados a números. El órden es completamente al azar.

* **Usuarios Pasajero**:
    * **¿Cómo se asignaron las contraseñas?**: Se agarró el pasaporte del pasajero y su nombre, se mezclaron los strings y después se tomó un largo de entre 6 y 12 caracteres para generar la contraseña.

## Funcionaldad Adicional

Se decidió implementar como funcionalidad adicional la opción de filtrar las reservas del pasajero dependiendo del origen y del destino. Para realizar la correción de esta funcionalidad, hay que entrar con algún usuario pasajero, y en la página donde salen su nombre y su pasaporte, filtrar por las ciudades. Luego, ahí mismo se podrá ver qué vuelos tiene cada pasajero reservado para esos parámetros. También se da la opción de resetear la búsqueda y que vuelvan a aparecer todas sus reservas. Se consideró implementar de manera adicional los filtros de hora y fecha de salida de los vuelos, pero considerando que un pasajero no tiene tantas reservas para las mismas cuidades en distintas fechas, no nos pareció que iban a aportar a la búsqueda por lo específico que era (a diferencia de lo útil que puede resultar un filtro similar para hacer las reservas de un nuevo vuelo). 

## Usuarios y Contraseñas

ID  | USUARIO | CONTRASEÑA    |  TIPO
----|-------- | ------------- | -------------
1 |	DGAC |	admin	| admin dgac
2|	IBE	| e0a172ce	| compania aerea
3|	XLE |	8824db09 |	compania aerea
4|	ADC |	833a8fdf |	compania aerea
5|	LAW |	a134bf20 |	compania aerea
6|	ETA |	ba033a78 |	compania aerea
7|	KAI |	adb70c97 |	compania aerea
8|	LRC	| db5d2ee9	| compania aerea
9|	UCA |	735b521f |	compania aerea
10|	AZI | 	e44649b4|	compania aerea
11|	COG |	4a91372b|	compania aerea
12|	QAF |	2ef69a2d|	compania aerea
13|	LUD	| 417ada84	|compania aerea
14|	LAT |	51f4f531|	compania aerea
15|	EAL	| 8e1a4fb8	|compania aerea
16|	KEA |	29aaf8d3|	compania aerea
17|	BTA	|48dcb1a6	|compania aerea
18|	LAM	|57e3b0a0	|compania aerea
19|	MPH	|5f0112a3	|compania aerea
20|	NCY	|62a37736	|compania aerea
21|	UAN	|c1789dc6	|compania aerea
22|	A17367163|	A1JgBrne7e3|	pasajero
23|	A40223024|	2n0t2i4|	pasajero
24|	B30315997|	hSn05933waai|	pasajero
25|	C59429415|	aCi4B1	|pasajero
26|	C63211080|	nhlB10ia0c2i|	pasajero
27|	C87025090|	002Dka79ia	|pasajero
28|	D39176940|	7kPhoi49t6	|pasajero
29|	D46250570|	2n6DhlMcM0e	|pasajero
30|	D64763364v|	D3Js3n4s6h	|pasajero
31|	D76513142	|c1ntnrD51er7	|pasajero
32|	D84069297|	6yo087	|pasajero
33|	D99418548|	SAihl4519s|	pasajero
34|	E44895667|	7d6ny9	|pasajero
35|	F09235820|	aiKn0ar	|pasajero
36|	F15206543|	rKr3ei	|pasajero
37|	F23633774|	zdaa6R3	|pasajero
38|	F69466449|	fiJ6nenn6te|	pasajero
39|	F70729457|	70s2J7oHi	|pasajero
40|	F89276118|	ls8o82	|pasajero
41|	G04408945|	44RBGr40e|	pasajero
42|	G15489494|	i4ohn9r5sn|	pasajero
43|	G69357980|	6J5ey8arP9kG|	pasajero
44|	G96421276|	2rnGnMe4a	|pasajero
45|	H23592194|	aebl5i2G1t4	|pasajero
46|	H44001820|	n14tnb082R	|pasajero
47|	I07581924|	Ilo7w0e29	|pasajero
48|	I19062847|	Crihat	|pasajero
49|	I63697476|	76ul63imi9|	pasajero
50|	I71394677|	76aI4Mi7	|pasajero
51|	I71542181|	4dJiA7r	|pasajero
52|	I78807927|	7lleRo2	|pasajero
53|	J33947155|	cr33hc	|pasajero
54|	J34719947|	h49r1e9tea|	pasajero
55|	J39937043|	Ji3selona4e9|	pasajero
56|	J46009647|	0rOc4Eoi6	|pasajero
57|	J46610530|	610nT0r	|pasajero
58|	J47009281|	81tew940saD	|pasajero
59|	J76795477|	l7haet7ka7y	|pasajero
60|	J86333952|	J6areL8ws93	|pasajero
61|	K07643594|	67naKS3od9	|pasajero
62|	L56496275|	t9Lo5lyeClr6	|pasajero
63|	L87663260|	8h7oeB6alL	|pasajero
64|	L94336722|	J9ku34na3Wts|	pasajero
65|	L97895867|	lL979SWim	|pasajero
66|	M25657749|	27B9t7n4M	|pasajero
67|	N07672370|	lNiveno	|pasajero
68|	N15841852|	c2oJne851|	pasajero
69|	N24258653|	D3gaN6	|pasajero
70|	N47846939|	86JLe743|	pasajero
71|	N49905893|	9N9aE48t5|	pasajero
72|	N55362278|	22aau76	|pasajero
73|	N68461604|	yuz6e418|	pasajero
74|	O01507856|	8s700aO5me6	|pasajero
75|	O04335063|	nso06aOm	|pasajero
76|	O41678476|	O6oAn7lw8n	|pasajero
77|	O85238546|	r42h3ado5	|pasajero
78|	P11550487|	a85zr1M7	|pasajero
79|	P34583903|	3sHe3K9eP3	|pasajero
80|	P84627985|	naa4es27P	|pasajero
81|	Q62966391|	ii2kreaPr	|pasajero
82|	Q76465555|	5h45da	|pasajero
83|	R10584802|	02RuaJ184	|pasajero
84|	R17782317|	a7ca2a	|pasajero
85|	R56995721|	eK1Rr955|	pasajero
86|	S03830222|	0dAaaS	|pasajero
87|	S05106445|	4neS1dgry6r|	pasajero
88|	T18212951|	1omlT982e|	pasajero
89|	T33834498|	Ae4Alnrnjld|	pasajero
90|	T59160871|	osu5701JT	|pasajero
91|	T72132858|	hu8a1528LT	|pasajero
92|	U37349664|	e6iiaU3r7t	|pasajero
93|	U68917595|	n9P8ao	|pasajero
94|	V03976673|	7G7M63e09n	|pasajero
95|	V39868007|	Cd0a6rb08	|pasajero
96|	V79731274|	Ctoi1eVlr9ly|	pasajero
97|	W06120402|	0Arm20adaW4	|pasajero
98|	W23173820|	01r3liW7a3	|pasajero
99|	X49704522|	s94a2sj0Ro	|pasajero
100|	X66304032|	0do3V0	|pasajero
101	|X84322989|	rt9M3ls.eA2	|pasajero
102|	X91486662|	42Hm6t6	|pasajero
103|	Y05451726|	eJ7h6nYs|	pasajero
104|	Y13424296 |	eh61P2i9t|	pasajero
105	|Y23187711|	Y711dWr7i	|pasajero
106	|Y33413387|	3KYr1a43	|pasajero
107	|Y38354449|	t9e84Nyi4Y	|pasajero
108|	Y88079794|	9dye47B70	|pasajero
109|	Z09262256|	o59lZsi6Jh2	|pasajero
110|	Z51226931|	e1MSwZotim	|pasajero
111|	Z87364523|	Za4376n	|pasajero
