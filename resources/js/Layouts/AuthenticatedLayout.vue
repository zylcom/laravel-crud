<script setup lang="ts">
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";
import { ChevronDownIcon, LayoutDashboardIcon, MenuIcon, ShoppingBagIcon, UsersRoundIcon } from "lucide-vue-next";

const showSidebar = ref(false);
</script>

<template>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button
                        aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        @click="showSidebar = !showSidebar"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <MenuIcon />
                    </button>

                    <Link :href="route('dashboard')" class="ms-2 md:me-24 hidden md:block">
                        <ApplicationLogo class="w-8 h-8" />
                    </Link>
                </div>

                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button type="button" class="flex gap-x-2 text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">
                            {{ $page.props.auth.user.name }}

                            <ChevronDownIcon />
                        </button>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                        <DropdownLink :href="route('logout')" method="post" as="button"> Log Out </DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </div>
    </nav>

    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
        :class="{ 'translate-x-0': showSidebar }"
        aria-label="Sidebar"
    >
        <div class="h-full px-3 overflow-y-auto py-4">
            <ul class="space-y-2 font-medium">
                <li>
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group"
                        :class="{ 'bg-gray-100': route().current('dashboard') }"
                    >
                        <LayoutDashboardIcon />
                        <span class="ms-3">Dashboard</span>
                    </Link>
                </li>
                <!-- <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <UsersRoundIcon />
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                    </li> -->
                <li>
                    <Link
                        :href="route('products.index')"
                        :class="{ 'bg-gray-100': route().current('products.*') }"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group"
                    >
                        <ShoppingBagIcon />
                        <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>

    <main class="md:ml-64 p-6 bg-gray-100 min-h-screen">
        <div class="bg-white border shadow rounded-lg overflow-hidden w-full mt-14">
            <slot />
        </div>
    </main>
</template>
