<template>
    <form @submit.prevent="create">
        <div>
            <div>
                <label>Beds</label>
                <input v-model.number="form.beds" type="text" />
                <div v-if="form.errors.beds">
                    {{ form.errors.beds }}
                </div>
            </div>

            <div>
                <label>Baths</label>
                <input v-model.number="form.baths" type="text" />
                <div v-if="form.errors.beds">
                    {{ form.errors.baths }}
                </div>
            </div>

            <div>
                <label>Area</label>
                <input v-model.number="form.area" type="text" />
                {{ form.errors.area }}
            </div>

            <div>
                <label>City</label>
                <input v-model="form.city" type="text" />
                {{ form.errors.city }}
            </div>

            <div>
                <label>Post Code</label>
                <input v-model="form.code" type="text" />
                {{ form.errors.code }}
            </div>

            <div>
                <label>Street</label>
                <input v-model="form.street" type="text" />
                {{ form.errors.street }}
            </div>

            <div>
                <label>Street Nr</label>
                <input v-model.number="form.street_nr" type="text" />
                {{ form.errors.street_nr }}
            </div>

            <div>
                <label>Price</label>
                <input v-model.number="form.price" type="text" />
                {{ form.errors.price }}
            </div>

            <div>
                <button type="submit">Create</button>
            </div>
        </div>
    </form>
</template>

<script setup>
// import { reactive } from 'vue'           // Using just Inertia library
// import { Inertia, useForm } from '@inertiajs/inertia'
import { useForm } from '@inertiajs/inertia-vue3'

// const form = reactive({                  // Using just Inertia library
const form = useForm({                 // useForm gives you access to all errors that occur on every attribute
    beds: 0,
    baths: 0,
    area: 0,
    city:null,
    street:null,
    code: null,
    street_nr:null,
    price:0
})

// const create = () => Inertia.post('/listing', form)      // Using just Inertia library
// const create = () => form.post('/listing')
const create = () => form.post(route('listing.store'))       // Using zyggy plugin routing instead

</script>

<style scoped>
    label {
        margin-right: 2em;
    }
    div {
        padding: 2px
    }
</style>
