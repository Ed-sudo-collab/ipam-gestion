<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { props } = usePage();
const users = props.value.users; // Collection paginée
</script>

<template>
    <Head title="Gestion des utilisateurs" />

    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Utilisateurs</h1>
            <Link href="/users/create">
                <PrimaryButton>Ajouter un utilisateur</PrimaryButton>
            </Link>
        </div>

        <!-- Flash message -->
        <div v-if="$page.props.flash.success" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ $page.props.flash.success }}
        </div>

        <div class="overflow-x-auto bg-white dark:bg-zinc-900 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dernier login</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                    <tr v-for="user in users.data" :key="user.id_utilisateur" class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4 text-gray-800 dark:text-white">{{ user.nom_utilisateur }}</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">{{ user.email }}</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">
                            {{ user.roles.map(r => r.name).join(', ') }}
                        </td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">{{ user.statut }}</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">
                            {{ user.dernier_login ? new Date(user.dernier_login).toLocaleString() : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <Link :href="`/users/${user.id_utilisateur}/edit`" class="text-indigo-600 hover:text-indigo-900">Modifier</Link>
                            <form :action="`/users/${user.id_utilisateur}`" method="post" @submit.prevent="$inertia.delete($event.target.action)">
                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <div class="flex justify-center space-x-2">
                <button v-for="page in users.last_page" :key="page" @click="$inertia.get(`/users?page=${page}`)"
                        :class="page === users.current_page ? 'px-3 py-1 bg-indigo-500 text-white rounded' : 'px-3 py-1 bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white rounded'">
                    {{ page }}
                </button>
            </div>
        </div>
    </div>
</template>
