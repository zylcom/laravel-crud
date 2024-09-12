<script setup lang="ts">
import { ChevronDownIcon, LayoutDashboardIcon, LogOut, MenuIcon, ShoppingBagIcon, TagsIcon, UserIcon, UsersRoundIcon } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";

const showSidebar = ref(false);
</script>

<template>
    <nav class="fixed top-0 z-50 w-full border-b border-gray-200 bg-white">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button
                        aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden"
                        @click="showSidebar = !showSidebar"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <MenuIcon />
                    </button>

                    <Link :href="route('dashboard')" class="ms-2 hidden md:me-24 md:block">
                        <ApplicationLogo class="h-8 w-8" />
                    </Link>
                </div>

                <Dropdown align="right">
                    <template #trigger>
                        <button type="button" class="flex gap-x-2 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700">
                            {{ $page.props.auth.user.name }} {{ $page.props.auth.user.role === "admin" ? "(Admin)" : "" }}

                            <ChevronDownIcon />
                        </button>
                    </template>

                    <template #content>
                        <div class="flex flex-col divide-y [&_button]:rounded">
                            <Link
                                :href="route('profile.edit')"
                                type="button"
                                title="Profile"
                                class="p-1 hover:bg-gray-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2"
                            >
                                <span>
                                    <UserIcon class="h-4 w-4" />
                                    Profile
                                </span>
                            </Link>

                            <Link
                                :href="route('logout')"
                                as="button"
                                method="post"
                                type="button"
                                title="Log out"
                                class="p-1 hover:bg-gray-100 [&_span]:flex [&_span]:items-center [&_span]:gap-2"
                            >
                                <span>
                                    <LogOut class="h-4 w-4" />
                                    Log out
                                </span>
                            </Link>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>
    </nav>

    <aside
        class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-16 transition-transform md:translate-x-0"
        :class="{ 'translate-x-0': showSidebar }"
        aria-label="Sidebar"
    >
        <div class="h-full overflow-y-auto px-3 py-4">
            <ul class="space-y-2 font-medium">
                <li>
                    <Link
                        :href="route('dashboard')"
                        class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                        :class="{ 'bg-gray-100': route().current('dashboard') }"
                    >
                        <LayoutDashboardIcon />
                        <span class="ms-3">Dashboard</span>
                    </Link>
                </li>

                <template v-if="$page.props.auth.user.role === 'admin'">
                    <li>
                        <Link
                            :href="route('users.index')"
                            :class="{ 'bg-gray-100': route().current('users.*') }"
                            class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                        >
                            <UsersRoundIcon />
                            <span class="ms-3 flex-1 whitespace-nowrap">Users</span>
                        </Link>
                    </li>

                    <li>
                        <Link
                            :href="route('categories.index')"
                            :class="{ 'bg-gray-100': route().current('categories.*') }"
                            class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                        >
                            <TagsIcon />
                            <span class="ms-3 flex-1 whitespace-nowrap">Categories</span>
                        </Link>
                    </li>
                </template>

                <li>
                    <Link
                        :href="route('products.index')"
                        :class="{ 'bg-gray-100': route().current('products.*') }"
                        class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                    >
                        <ShoppingBagIcon />
                        <span class="ms-3 flex-1 whitespace-nowrap">Products</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>

    <main class="min-h-screen bg-gray-100 p-6 md:ml-64">
        <div class="mt-14 w-full overflow-hidden rounded-lg border bg-white shadow">
            <slot />
        </div>
    </main>
</template>
