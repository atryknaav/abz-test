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

export interface UsersResponse {
    success: boolean;
    page: number;
    count: number;
    total_pages: number;
    total_users: number;
    users: {
        data: User[];
        meta: {
          links: {
            url: string | null;
            label: string;
            active: boolean;
          }[];
        };
      };
}
export interface UserResponse {
    success: true,
    user: User
}


export interface Response422 {
  success: string,
  message: string,
  fails: string[]
}
export interface Response404 {
  success: string,
  message: string,
}


export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
