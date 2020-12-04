class TableUser {
    constructor(username, role) {
      this.username = username;
      this.role = role;
    }

    get username() {
        return this.username;
    }

    set username(name){
        this.username = name;
    }

    get role() {
        return this.role;
    }

    set role(userrole){
        this.role = userrole;
    }
}