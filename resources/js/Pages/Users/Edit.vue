<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue'; // composant custom pour les selects

const props = defineProps({
    user: Object,
    roles: Array, // liste des rôles disponibles
});

const form = useForm({
    nom_utilisateur: props.user.nom_utilisateur,
    email: props.user.email,
    mot_de_passe_hash: '',
    mot_de_passe_hash_confirmation: '',
    type_utilisateur: props.user.type_utilisateur,
    statut: props.user.statut,
    role: props.user.roles.map(r => r.name)[0] || '', // prendre le 1er rôle
});

const submit = () => {
    form.put(`/users/${props.user.id_utilisateur}`);
};
</script>

<template>
  <Head title="Modifier l'utilisateur" />

  <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-zinc-900 rounded-lg shadow-lg">
    <h1 class="text-2xl font-semibold mb-6 text-black dark:text-white">Modifier l'utilisateur</h1>

    <form @submit.prevent="submit" class="space-y-6">
      <!-- Nom utilisateur -->
      <div>
        <InputLabel for="nom_utilisateur" value="Nom d'utilisateur" />
        <TextInput
          id="nom_utilisateur"
          v-model="form.nom_utilisateur"
          type="text"
          class="mt-1 block w-full"
          required
        />
        <InputError :message="form.errors.nom_utilisateur" class="mt-2" />
      </div>

      <!-- Email -->
      <div>
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
          required
        />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <!-- Mot de passe (facultatif) -->
      <div>
        <InputLabel for="mot_de_passe_hash" value="Mot de passe (laisser vide pour ne pas changer)" />
        <TextInput
          id="mot_de_passe_hash"
          v-model="form.mot_de_passe_hash"
          type="password"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.mot_de_passe_hash" class="mt-2" />
      </div>

      <!-- Confirmation mot de passe -->
      <div>
        <InputLabel for="mot_de_passe_hash_confirmation" value="Confirmer le mot de passe" />
        <TextInput
          id="mot_de_passe_hash_confirmation"
          v-model="form.mot_de_passe_hash_confirmation"
          type="password"
          class="mt-1 block w-full"
        />
      </div>

      <!-- Type utilisateur -->
      <div>
        <InputLabel for="type_utilisateur" value="Type d'utilisateur" />
        <select
          id="type_utilisateur"
          v-model="form.type_utilisateur"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-zinc-800 dark:text-white"
        >
          <option value="INTERNE">INTERNE</option>
          <option value="ETUDIANT">ETUDIANT</option>
        </select>
        <InputError :message="form.errors.type_utilisateur" class="mt-2" />
      </div>

      <!-- Statut -->
      <div>
        <InputLabel for="statut" value="Statut" />
        <select
          id="statut"
          v-model="form.statut"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-zinc-800 dark:text-white"
        >
          <option value="ACTIF">ACTIF</option>
          <option value="INACTIF">INACTIF</option>
          <option value="BLOQUE">BLOQUE</option>
        </select>
        <InputError :message="form.errors.statut" class="mt-2" />
      </div>

      <!-- Rôle -->
      <div>
        <InputLabel for="role" value="Rôle" />
        <select
          id="role"
          v-model="form.role"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-zinc-800 dark:text-white"
        >
          <option v-for="r in roles" :key="r" :value="r">{{ r }}</option>
        </select>
        <InputError :message="form.errors.role" class="mt-2" />
      </div>

      <!-- Bouton -->
      <div class="flex justify-end">
        <PrimaryButton :disabled="form.processing">
          Mettre à jour
        </PrimaryButton>
      </div>
    </form>
  </div>
</template>
