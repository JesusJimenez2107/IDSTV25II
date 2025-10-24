function getPokeData() {
  const pokemonName = document.getElementById('pokemonName').value.toLowerCase().trim();
  const dataDiv = document.getElementById('poke_data');
  const nameTag = document.getElementById('poke_name');

  dataDiv.innerHTML = '';
  nameTag.innerHTML = '';

  if (!pokemonName) {
    nameTag.innerHTML = 'Por favor ingresa un nombre';
    return;
  }

  fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Pokémon no encontrado');
      }
      return response.json();
    })
    .then(data => {
      dataDiv.innerHTML = `<img src="${data.sprites.front_default}" alt="${data.name}">`;
      nameTag.innerHTML = data.name;
    })
    .catch(error => {
      nameTag.innerHTML = error.message;
    });
}