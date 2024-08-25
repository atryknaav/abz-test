export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    password: string;
    photo: string;
    phone: string;
    position_id: number;
    position: string;
    remember_token: string;
}


export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
