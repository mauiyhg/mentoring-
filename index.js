// On instancie express
const express = require("express");
const app = express();

// On charge "path"
const path = require("path");

// On autorise le dossier "public"
app.use(express.static(path.join(__dirname, "public")));

// On crée le serveur http
const http = require("http").createServer(app);

// On instancie socket.io
const io = require("socket.io")(http);

// On charge sequelize
const Sequelize = require("sequelize");

// On fabrique le lien de la base de données pour la route /
const dbPath = path.resolve(__dirname, "chat.sqlite");

// On se connecte à la base pour la route /
const sequelize = new Sequelize("database", "username", "password", {
    host: "localhost",
    dialect: "sqlite",
    logging: false,
    
    // Sqlite seulement
    storage: dbPath
});

// On charge le modèle "Chat" pour la route /
const Chat = require("./Models/Chat")(sequelize, Sequelize.DataTypes);
// On effectue le chargement "réel" pour la route /
Chat.sync();

// On fabrique le lien de la base de données pour la route /chat
const dbPath2 = path.resolve(__dirname, "chat2.sqlite");

// On se connecte à la base pour la route /chat
const sequelize2 = new Sequelize("database", "username", "password", {
    host: "localhost",
    dialect: "sqlite",
    logging: false,
    
    // Sqlite seulement
    storage: dbPath2
});

// On charge le modèle "Chat" pour la route /chat
const Chat2 = require("./Models/Chat")(sequelize2, Sequelize.DataTypes);
// On effectue le chargement "réel" pour la route /chat
Chat2.sync();

// On crée la route /
app.get("/", (req, res) => {
    res.sendFile(__dirname + "/indexo.html");
});

// On crée la route /chat
app.get("/chat", (req, res) => {
    res.sendFile(__dirname + "/indexo2.html");
});

// On écoute l'évènement "connection" de socket.io pour la route /
io.of("/").on("connection", (socket) => {
    console.log("Une connexion s'active");

    // On écoute les déconnexions
    socket.on("disconnect", () => {
        console.log("Un utilisateur s'est déconnecté");
    });

    // On écoute les entrées dans les salles
    socket.on("enter_room", (room) => {
        // On entre dans la salle demandée
        socket.join(room);
        console.log(socket.rooms);

        // On envoie tous les messages du salon
        Chat.findAll({
            attributes: ["id", "name", "message", "room", "createdAt"],
            where: {
                room: room
            }
        }).then(list => {
            socket.emit("init_messages", {messages: JSON.stringify(list)});
        });
    });

    // On écoute les sorties dans les salles
    socket.on("leave_room", (room) => {
        // On entre dans la salle demandée
        socket.leave(room);
        console.log(socket.rooms);
    });

    // On gère le chat
    socket.on("chat_message", (msg) => {
        // On stocke le message dans la base
        const message = Chat.create({
            name: msg.name,
            message: msg.message,
            room: msg.room,
            createdAt: msg.createdAt
        }).then(() => {
            // Le message est stocké, on le relaie à tous les utilisateurs dans le salon correspondant
            io.in(msg.room).emit("received_message", msg);
        }).catch(e => {
            console.log(e);
        });    
    });

    // On écoute les messages "typing"
    socket.on("typing", msg => {
        socket.to(msg.room).emit("usertyping", msg);
    })
});

// On écoute l'évènement "connection" de socket.io pour la route /chat
io.of("/chat").on("connection", (socket) => {
    console.log("Une connexion s'active pour la route /chat");

    // On écoute les déconnexions
    socket.on("disconnect", () => {
        console.log("Un utilisateur s'est déconnecté pour la route /chat");
    });

    // On écoute les entrées dans les salles pour la route /chat
    socket.on("enter_room", (room) => {
        // On entre dans la salle demandée
        socket.join(room);
        console.log(socket.rooms);

        // On envoie tous les messages du salon de la route /chat
        Chat2.findAll({
            attributes: ["id", "name", "message", "room", "createdAt"],
            where: {
                room: room
            }
        }).then(list => {
            socket.emit("init_messages", {messages: JSON.stringify(list)});
        });
    });

    // On écoute les sorties dans les salles pour la route /chat
    socket.on("leave_room", (room) => {
        // On entre dans la salle demandée
        socket.leave(room);
        console.log(socket.rooms);
    });

    // On gère le chat pour la route /chat
    socket.on("chat_message", (msg) => {
        // On stocke le message dans la base de données de la route /chat
        const message = Chat2.create({
            name: msg.name,
            message: msg.message,
            room: msg.room,
            createdAt: msg.createdAt
        }).then(() => {
            // Le message est stocké, on le relaie à tous les utilisateurs dans le salon correspondant
            io.in(msg.room).emit("received_message", msg);
        }).catch(e => {
            console.log(e);
        });    
    });

    // On écoute les messages "typing" pour la route /chat
    socket.on("typing", msg => {
        socket.to(msg.room).emit("usertyping", msg);
    })
});

// On va demander au serveur http de répondre sur le port 3000
http.listen(3000, () => {
    console.log("J'écoute le port 3000");
});
