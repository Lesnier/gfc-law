const team = [
    {
        id: 1,
        name: "Hernán Facundo Castro",
        tag: "Socio",
        image: "imas/socios/castro.jpg",
        email: "hernan.castro@ayc-abogados.com.ar",
        role: "",
        description: [

            "Abogado graduado en la Universidad de Morón. 1999.",
            "Posgrado en Asesoramiento Jurídico de Empresas en la Universidad Argentina de la Empresa-  2001.",
            "Posgrado en Desarrollo General de Negocios en la Pontificia Universidad Católica Argentina 2004.",
            "Su práctica está focalizada en el asesoramiento de empresas, particularmente en asuntos de índole societario, propiedad intelectual y Real Estate.",
            "Participo en el dictado de Seminarios de Capacitación en diversas empresas, e instituciones orientadas al Derecho Comercial,  Defensa al consumidor y Marcas y Patentes. Habilitado para actuar en las jurisdicciones de la Provincia de Buenos Aires y  Ciudad Autónoma de Buenos Aires.",
            // "Durante su experiencia laboral se ha desempeñado como:",
            // "Abogado Senior de Wal- Mart Argentina, a cargo del asesoramiento en materia comercial y societaria.  Miembro de la Comisión de Abogados de la ASU (Asociación de Supermercados Unidos. Abogado Consultor de la CAS- FASA. (Cámara Argentina de Supermercados).",
            // "Abogado Asesor de IFPI LATAM (International Federation of Phonographic INdustry Latin America Division), a cargo de división antipiratería de fonogramas mediante el uso de tecnologías informáticas.  Control de Licencia.",
            // "Abogado asociado al Estudio Mille, vinculado a las cuentas Microsoft Argentina, Dell Computers Corp., EMMIS Broadcasting Corp (Radio Diez- Mega 98.3), Leb Computers S.A., Banco Credicoop, Polaroid Argentina y Yahoo! Argentina, entre otras. Miembro del Poder Judicial de la Provincia de Buenos Aires.  Juzgado Civil y Comercial nro. 4, de San Martin.",
            // "Idiomas: Español e Inglés",

        ]
    },
    {
        id: 2,
        name: "Daniela Lamazou",
        tag: "Socio",
        image: "imas/socios/daniela.jpg",
        email: "daniela.lamazou@ayc-abogados.com.ar",
        role: "",
        description: []
    },
    {
        id: 3,
        name: "Romina Perklic",
        tag: "Socio",
        image: "imas/socios/romina.jpg",
        email: "rominal.perklic@ayc-abogados.com.ar",
        role: "",
        description: []
    }
]


document.addEventListener('DOMContentLoaded', (event) => {
    console.log('Loaded');
    buildListMembers();
});


const buildListMembers = () => {
    let html = ``;
    for (const key in team) {

        html += `<li>
          <a href="javascript:void(0)" onclick="buildMemberBioHtml(${parseInt(team[key].id)},this)" >
            ${team[key].name}
          </a>
        </li>`;
    }
    document.querySelector("#list-select-members").innerHTML = html;
};


const buildMemberBioHtml = (teamMemberId,element) => {

    const countItem = document.querySelector("#list-select-members").children.length;

    for (let i = 0; i < countItem; i++) {
       const ele = document.querySelector("#list-select-members").children.item(i);
        ele.classList.remove('active')
    }

    element.parentNode.classList.add('active');

    const teamMember = team.find((item) => item.id === teamMemberId);
    let html = ``;
    document.querySelector("#member-name").innerHTML = teamMember.name;
    document.querySelector("#member-email").innerHTML = teamMember.email;
    document.querySelector("#member-tag").innerHTML = teamMember.tag;

    for (const key in teamMember.description) {
        html += `<p> ${teamMember.description[key]}</p>`;
    }

    document.querySelector("#member-bio").innerHTML = html;
    document.querySelector("#foto_socio").innerHTML = `<img src="` + teamMember.image + `" width="188" height="196" />`;
    document.querySelector("#bio").style.display = "block";
    document.querySelector("#bio-init").style.display = "none";


}

