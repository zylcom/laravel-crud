import { Config } from "ziggy-js";

export type NotificationData = {
    message: string;
};

export type Notification = {
    id: string;
    type: string;
    data: NotificationData;
    read_at: string;
    createdAgo: string;
    created_at: string;
    updated_at: string;
};

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    role: "admin" | "user";
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        notifications: Notification[];
    };
    flash: {
        message: string;
    };
    ziggy: Config & { location: string };
};
