<script>
	export default {
		name:'Create',
		props: {
			services: Array,
		},
		data() {
			return {
				newApartment: {
					title: '',
					description: '',
					cap: '',
					city: '',
					street: '',
					civic_number: '',
					rooms: 1,
					beds: 1,
					bathrooms: 1,
					size: 12,
					visible: 0,
					activeServices: [],
				}
			}
		},
		methods: {
			pushService(serviceId) {
				if(this.activeServices.includes(serviceId)) {
					this.activeServices.splice(this.activeServices.indexOf(serviceId), 1)
				}
				else {
					this.activeServices.push(serviceId)
				}
			}
		}
	}
</script>

<template>
    <form @submit.prevent="submit">
		<div class="mb-3">
			<label for="title">Nome Appartamento</label>
			<input
				type="text"
				id="title"
				name="title"
				v-model="newApartment.title"
				placeholder="Inserisci il nome..."
				required
				autofocus
				maxlength="255">
		</div>

		<div class="mb-3">
			<label for="description">Descrizione</label>
			<textarea
				v-model="newApartment.description"
				rows="10"
				id="description"
				name="description"
				placeholder="Inserisci una descrizione per la tua abitazione..."
				required
				maxlength="3000"></textarea>
		</div>
		
		<h4>Indirizzo</h4>
		<div class="mb-3">
			<label for="cap">CAP</label>
			<input
				v-model="newApartment.cap"
				type="text"
				id="cap"
				name="cap"
				placeholder="41012"
				pattern="[0-9]{5}"
				required
				maxlength="5">
		</div>
		<div class="mb-3">
			<label for="city">Città</label>
			<input
				v-model="newApartment.city"
				type="text"
				id="city"
				name="city"
				placeholder="Inserisci una città"
				required
				maxlength="255">
		</div>
		<div class="mb-3">
			<label for="street">Via</label>
			<input
				v-model="newApartment.street"
				type="text"
				id="street"
				name="street"
				placeholder="Inserisci la via"
				required
				maxlength="255">
		</div>
		<div class="mb-3">
			<label for="civic_number">Numero civico</label>
			<input
				v-model="newApartment.civic_number"
				type="text"
				id="civic_number"
				name="civic_number"
				placeholder="Inserisci il numero civico"
				required
				maxlength="255">
		</div>

		<div class="mb-3">
			<label for="rooms">N. di stanze</label>
			<input
				v-model="newApartment.rooms"
				type="number"
				min="1"
				max="10"
				id="rooms"
				placeholder="Da 1 a 10"
				name="rooms"
				required>
		</div>

		<div class="mb-3">
			<label for="beds">N. di letti</label>
			<input
				v-model="newApartment.beds"
				type="number"
				min="1"
				max="10"
				placeholder="Da 1 a 10"
				id="beds"
				name="beds"
				required>
		</div>

		<div class="mb-3">
			<label for="bathrooms">N. di bagni</label>
			<input
				v-model="newApartment.bathrooms"
				type="number"
				min="1"
				max="4"
				placeholder="Da 1 a 4"
				id="bathrooms"
				name="bathrooms"
				required>
		</div>

		<div class="mb-3">
			<label for="size">Metri quadrati</label>
			<input
				v-model="newApartment.size"
				type="number"
				min="12"
				max="300"
				placeholder="Da 12 a 300"
				id="size"
				name="size"
				required>
		</div>

		<div class="mb-3">
			<label for="cover_img">Immagine di copertina</label>
			<input
				@change="'??'"
				required
				type="file"
				name="cover_img" 
				id="cover_img" 
				accept="image/*"
				placeholder="Inserisci l'immagine dell'appartamento">
		</div>

		<div class="mb-3 flex">
			<p class="me-2">Vuoi rendere già visibile l'appartamento?</p>
			<div>
				<label for="not-visibile">
					NO
				</label>
				<input
					v-model="newApartment.visible"
					type="radio" 
					id="not-visibile" 
					name="visibile" 
					value="0">

				<label for="visibile">
					SI
				</label>
				<input
					v-model="newApartment.visible"
					class="form-check-input"
					type="radio" 
					id="visibile" 
					name="visibile" 
					value="1">
			</div>
		</div>
		<div class="mb-3 flex">
			<p class="me-2">Servizi offerti</p>
			<div v-for="service in services">
				<label :for="service.id">
					{{ service.name }}
					{{ service.icon }}
				</label>
				<input
					v-model="newApartment.services"
					type="checkbox" 
					:id="service.id" 
					:name="service.id"  
					:value="service.id">
			</div>
		</div>

		<div>
			<button type="submit" class="btn btn-success">
				Salva nuovo progetto
			</button>
		</div>
            
    </form>

</template>

<style scoped>



</style>