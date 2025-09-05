<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    nom_utilisateur: '',
    email: '',
    mot_de_passe_hash: '',
    mot_de_passe_hash_confirmation: '',
    type_utilisateur: 'INTERNE',
    statut: 'ACTIF',
    role: '',
});

const submit = () => {
    form.post('/users');
};
</script>

<template>
    <Head title="Créer utilisateur" />

    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Créer un utilisateur</h1>

        <form @submit.prevent="submit" class="space-y-4 bg-white dark:bg-zinc-900 p-6 rounded-lg shadow">
            <div>
                <InputLabel for="nom_utilisateur" value="Nom utilisateur" />
                <TextInput id="nom_utilisateur" v-model="form.nom_utilisateur" class="mt-1 block w-full" required />
                <InputError :message="form.errors.nom_utilisateur" class="mt-2" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" class="mt-1 block w-full" required />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div>
                <InputLabel for="mot_de_passe_hash" value="Mot de passe" />
                <TextInput id="mot_de_passe_hash" type="password" v-model="form.mot_de_passe_hash" class="mt-1 block w-full" required />
                <InputError :message="form.errors.mot_de_passe_hash" class="mt-2" />
            </div>

            <div>
                <InputLabel for="mot_de_passe_hash_confirmation" value="Confirmation mot de passe" />
                <TextInput id="mot_de_passe_hash_confirmation" type="password" v-model="form.mot_de_passe_hash_confirmation" class="mt-1 block w-full" required />
            </div>

            <div>
                <InputLabel for="type_utilisateur" value="Type utilisateur" />
                <select id="type_utilisateur" v-model="form.type_utilisateur" class="mt-1 block w-full rounded border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-800 dark:text-white">
                    <option value="INTERNE">INTERNE</option>
                    <option value="ETUDIANT">ETUDIANT</option>
                </select>
            </div>

            <div>
                <InputLabel for="statut" value="Statut" />
                <select id="statut" v-model="form.statut" class="mt-1 block w-full rounded border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-800 dark:text-white">
                    <option value="ACTIF">ACTIF</option>
                    <option value="INACTIF">INACTIF</option>
                    <option value="BLOQUE">BLOQUE</option>
                </select>
            </div>

            <div>
                <InputLabel for="role" value="Rôle" />
                <TextInput id="role" v-model="form.role" class="mt-1 block w-full" placeholder="ADMIN / USER ..." required />
            </div>

            <div class="flex justify-end">
                <PrimaryButton :disabled="form.processing">Créer</PrimaryButton>
            </div>
        </form>
    </div>
</template>
