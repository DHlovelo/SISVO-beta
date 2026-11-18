
CREATE DATABASE IF NOT EXISTS sisvov_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sisvov_db;

CREATE TABLE IF NOT EXISTS reportes_mantenimiento (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    tipo_reporte VARCHAR(100) NOT NULL,
    correo_contacto VARCHAR(150) NOT NULL,
    detalle_mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado_revision ENUM('Pendiente', 'En Revisión', 'Resuelto') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS chatbot_conocimiento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(60) NOT NULL UNIQUE,
    categoria VARCHAR(80) NOT NULL,
    pregunta VARCHAR(255) NOT NULL,
    respuesta TEXT NOT NULL,
    palabras_clave VARCHAR(500) NOT NULL DEFAULT '',
    prioridad INT NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO chatbot_conocimiento
(codigo, categoria, pregunta, respuesta, palabras_clave, prioridad) VALUES
('saludo','General','Hola','¡Hola! Soy SISVOV Assistant. Puedo orientarte sobre el test vocacional, áreas de estudio, becas y cómo consultar información de instituciones. ¿Qué quieres saber?','hola,buenas,buen dia,saludos,hey',10),
('que_es','SISVOV','¿Qué es SISVOV?','SISVOV es una plataforma de orientación vocacional. El chatbot puede ayudarte a aclarar tus dudas para que tomes decisiones informadas sobre tus estudios.','que es sisvov,para que sirve sisvov,sistema vocacional',10),
('test_inicio','Test','¿Cómo puedo iniciar el test vocacional?','Para realizar el test, busca la sección Test Vocacional de la plataforma SISVOV. Si no encuentras el acceso o el test presenta fallas, puedes comunicarlo mediante el buzón de mantenimiento.','test vocacional,iniciar test,realizar test,orientacion vocacional,cuestionario',10),
('test_resultado','Test','¿Para qué sirve un test vocacional?','Un test vocacional puede ayudarte a identificar intereses y explorar áreas de estudio. Sus resultados son orientativos: conviene complementarlos con investigación sobre las carreras y tus preferencias.','resultado del test,para que sirve el test,interpretar test,diagnostico vocacional',9),
('oferta_carreras','Carreras','¿Qué carreras puedo estudiar?','Puedes explorar distintas áreas, como tecnología, salud, educación, ciencias sociales, negocios o artes. La oferta concreta depende de cada universidad o instituto. Si me indicas un área y una ciudad, puedo ayudarte a formular una búsqueda más precisa.','carreras,que carreras ofrecen,que estudiar,opciones de estudio,oferta academica,profesiones',8),
('ingenieria','Carreras','¿Qué hace un profesional de Ingeniería de Sistemas?','Ingeniería de Sistemas se relaciona, entre otras actividades, con el desarrollo de software, los datos, los sistemas informáticos y la solución de problemas mediante tecnología. Los contenidos exactos varían según la institución.','ingenieria de sistemas,programacion,desarrollo de software,sistemas informaticos',8),
('medicina','Carreras','¿En qué consiste estudiar Medicina?','Medicina es un área orientada al estudio de la salud, la prevención y la atención de las personas. Los años de formación, prácticas y requisitos de ingreso dependen de la universidad y su normativa vigente.','medicina,que estudia medicina,carrera de medicina',7),
('becas','Becas','¿Cómo funcionan las becas?','Las becas y sus criterios dependen de cada institución y convocatoria. Para darte una orientación útil, dime el nombre de la universidad o instituto y la ciudad. No confirmaré porcentajes, montos ni plazos sin una fuente oficial vigente.','becas,ayuda economica,beca de estudio,financiamiento,descuento estudiantil',10),
('becas_requisitos','Becas','¿Cuáles son los requisitos para obtener una beca?','Los requisitos de becas pueden incluir antecedentes académicos u otras condiciones establecidas por la convocatoria. Es necesario consultar las bases oficiales de la institución y el periodo correspondiente. ¿Sobre qué universidad y ciudad preguntas?','requisitos de beca,postular a beca,solicitar beca,obtener beca',9),
('costos','Instituciones','¿Cuánto cuesta estudiar una carrera?','No dispongo de precios oficiales actualizados de cada carrera o institución. Los costos pueden variar según universidad, sede, carrera y gestión. Dime esos datos para precisar qué información necesitas verificar.','cuanto cuesta,precio de carrera,costo de universidad,mensualidad,matricula,aranceles',10),
('requisitos','Instituciones','¿Qué documentos necesito para inscribirme?','Cada institución establece sus propios requisitos de inscripción. Para evitar indicarte documentos incorrectos, consulta la convocatoria oficial o dime la institución, la sede y la carrera que te interesa.','requisitos de inscripcion,documentos de ingreso,inscribirme,matricularme,admision',10),
('ubicacion','Instituciones','¿Dónde queda una universidad o instituto?','Para ayudarte con una ubicación, necesito saber el nombre de la institución y la ciudad o sede. No daré direcciones sin confirmarlas.','ubicacion de universidad,direccion de instituto,donde queda,contacto de universidad,sedes',8),
('parvularia','Carreras','¿Qué es la formación en educación inicial o parvularia?','La formación en educación inicial se enfoca en el aprendizaje y desarrollo de niñas y niños pequeños. Los nombres de la carrera, la duración y las instituciones que la imparten deben verificarse para cada ciudad.','parvularia,educacion inicial,profesor de inicial,educacion infantil',8),
('indecision','Orientación','No sé qué carrera elegir, ¿qué puedo hacer?','Puedes empezar identificando qué actividades disfrutas, qué asignaturas te interesan y cómo te gustaría trabajar. Un test vocacional puede ayudarte a organizar tus opciones, pero la decisión final debe considerar también tus metas y la información de cada carrera.','no se que estudiar,no se que carrera elegir,que me recomiendas,indecision vocacional',8),
('reportar','Mantenimiento','¿Cómo reporto una respuesta equivocada?','Utiliza el botón del buzón de mantenimiento. Selecciona el tipo de reporte, escribe un correo de contacto y explica qué respuesta fue confusa o qué problema encontraste.','reportar error,buzon de mantenimiento,informar fallo,denunciar respuesta equivocada,sugerencia',10),
('gracias','General','Gracias','¡Con gusto! Si quieres, puedes escribir otra consulta sobre orientación vocacional.','gracias,muchas gracias,te agradezco',10);
