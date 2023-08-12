console.log("Delete");
// Configurar la URL del archivo PHP que contiene la función de eliminación
const deleteURL = 'http://localhost/moodle/local/laika/delete/delete.php'; // la URL correcta

// Función para realizar la eliminación de mensajes
async function deleteMessages() {
   fetch(deleteURL)
   .then(response =>{
    if (response.ok){
        console.log('Eliminado de la tabla laika_user_questions');
    }else{
        throw new Error('Error');
    }
   })
   .catch(error =>{
    console.error('Error',error );
   });
}

// Calcular la cantidad de milisegundos hasta la hora específica
const now = new Date();
const targetHour = 19; // Hora específica 
const targetMinute = 16; // Minuto específica 
const targetTime = new Date(
   now.getFullYear(),
   now.getMonth(),
   now.getDate(),
   targetHour,
   targetMinute,
   0
);
const timeUntilTarget = targetTime - now;

// Ejecutar la función deleteMessages() en la hora específica
setTimeout(deleteMessages,timeUntilTarget);