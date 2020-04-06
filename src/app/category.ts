export class Category {
    id: number;
    name: string;
    description: string;
    status: string;
    constructor(name: string, description: string) {
        this.name = name;
        this.description = description;
        this.status = 'publish';
    }
}
