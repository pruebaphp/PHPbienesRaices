const btnCrearPropiedad = document.querySelector('#btnCrearPropiedad');
const formCrearPropiedad = document.querySelector('#formCrearPropiedad');
const base_url = 'http://localhost/bienesRaicesPHP';
const imagenFile = document.querySelector('#imagen');

window.onload = ()=>{
    btnCrearPropiedad.addEventListener('click',crearPropiedad);
}

async function crearPropiedad(e){
    e.preventDefault();
    const url = base_url+'/admin/propiedades/crear.php';
    const formData = new FormData(formCrearPropiedad);
    console.log([...formData]);
    const respuesta = await fetch(url,{
        method:'POST',
        body: JSON.stringify(formData),
    });
    console.log(respuesta);
    console.log(imagenFile.files);
    //const data =  respuesta.json();
    //console.log(data);

}