<script>
import { useForm } from '@inertiajs/vue3';
	export default {
		name:'Create',
		props: {
			services: Array,
		},
		data() {
			return {
				newApartment: useForm({
					title: null,
					description: null,
					cap: null,
					city: null,
					street: null,
					civic_number: null,
					rooms: null,
					beds: null,
					bathrooms: null,
					size: null,
					cover_img: null,
					visible: null,
					activeServices: [],
				}),
			}
		},
		methods: {
			pushService(serviceId) {
				let servicesArray = this.newApartment.activeServices;
				if(servicesArray.includes(serviceId)) {
					servicesArray.splice(servicesArray.indexOf(serviceId), 1)
				}
				else {
					servicesArray.push(serviceId)
				}
			},//pushService
			submit() {
				this.newApartment.post(route('gestione-appartamenti.store'));
			},//submit
		},
	}
</script>

<template>
    <form @submit.prevent="submit">
		<!-- ----------------------TITLE---------------------- -->
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
			<div v-if="newApartment.errors.title">{{ newApartment.errors.title }}</div>
		</div>
	<!-- ----------------------DESCRIPTION---------------------- -->
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
			<div v-if="newApartment.errors.description">{{ newApartment.errors.description }}</div>
		</div>
	<!-- ----------------------ADDRESS---------------------- -->
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
			<div v-if="newApartment.errors.cap">{{ newApartment.errors.cap }}</div>
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
			<div v-if="newApartment.errors.city">{{ newApartment.errors.city }}</div>
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
			<div v-if="newApartment.errors.street">{{ newApartment.errors.street }}</div>
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
			<div v-if="newApartment.errors.civic_number">{{ newApartment.errors.civic_number }}</div>
		</div>
	<!-- ----------------------ROOMS---------------------- -->
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
			<div v-if="newApartment.errors.rooms">{{ newApartment.errors.rooms }}</div>
		</div>
	<!-- ----------------------BEDS---------------------- -->
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
			<div v-if="newApartment.errors.beds">{{ newApartment.errors.beds }}</div>
		</div>
	<!-- ----------------------BATHROOMS---------------------- -->
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
			<div v-if="newApartment.errors.bathrooms">{{ newApartment.errors.bathrooms }}</div>

		</div>
	<!-- ----------------------SIZE---------------------- -->
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
			<div v-if="newApartment.errors.size">{{ newApartment.errors.size }}</div>

		</div>
	<!-- ----------------------COVER IMG---------------------- -->
		<div class="mb-3">
			<label for="cover_img">Immagine di copertina</label>
			<input
				@input="newApartment.cover_img = $event.target.files[0]"
				required
				type="file"
				name="cover_img" 
				id="cover_img" 
				accept="image/*"
				placeholder="Inserisci l'immagine dell'appartamento">
				
				<!-- PER VEDERE PROGRESSO DI CARICAMENTO DEL FILE (E' TROPPO VELOCE PER VEDERE QUALCOSA) -->
				<!-- <progress v-if="newApartment.progress" :value="newApartment.progress.percentage" max="100">
					{{ newApartment.progress.percentage }}%
				</progress> -->

			<div v-if="newApartment.errors.cover_img">{{ newApartment.errors.cover_img }}</div>
		</div>
	<!-- ----------------------VISIBLE---------------------- -->
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
				<div v-if="newApartment.errors.visible">{{ newApartment.errors.visible }}</div>
			</div>
		</div>
	<!-- ----------------------SERVICES---------------------- -->
		<div class="mb-3 flex">
			<p class="me-2">Servizi offerti</p>
			<div v-for="service in services">
				<label :for="service.id">
					{{ service.name }}
					{{ service.icon }}
				</label>
				<input
					@click="pushService(service.id)"
					type="checkbox" 
					:id="service.id" 
					:name="service.id"  
					:value="service.id">
			</div>
			<div v-if="newApartment.errors.activeServices">{{ newApartment.errors.activeServices }}</div>
		</div>

		<div>
			<button type="submit" :disabled="newApartment.processing">
				Salva nuovo appartamento
			</button>
		</div>
            
    </form>

</template>

<style scoped>



</style>