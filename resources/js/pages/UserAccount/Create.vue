<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">Your Name</label>
                <input type="text" id="name" class="input" v-model="form.name" />
                <div class="input-error" v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>
            <div class="mt-4">
                <label for="email" class="label">E-mail</label>
                <input type="text" id="email" class="input" v-model="form.email" />
                <div class="input-error" v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input type="password" id="password" class="input" v-model="form.password "/>
                <div class="input-error" v-if="form.errors.password">{{ form.errors.password }}</div>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input type="password" id="password_confirmation" class="input" v-model="form.password_confirmation "/>
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Create Account</button>
                <div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500">
                        Already have a account? Click here
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/inertia-vue3'

const form = useForm({  // This helper will manage the validations errors that occurs in the backend by itself
    name:null,
    email:null,
    password:null,
    password_confirmation:null
})

const register = () => form.post(route('user-account.store'))

</script>

<style scoped>

</style>
