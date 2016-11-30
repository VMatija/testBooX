/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     30.11.2016 19:00:12                          */
/*==============================================================*/


drop table if exists Avtor;

drop table if exists Fakulteta;

drop table if exists Gradivo;

drop table if exists JeAvtor;

drop table if exists NaFakulteti;

drop table if exists Nakup;

drop table if exists Oblika;

drop table if exists Predmet;

drop table if exists PriPredmetu;

drop table if exists Profesor;

drop table if exists ProfesorZahteva;

drop table if exists Uporabnik;

/*==============================================================*/
/* Table: Avtor                                                 */
/*==============================================================*/
create table Avtor
(
   AvtorID              int not null,
   ImeAvtorja           varchar(1024) not null,
   PriimekAvtorja       varchar(1024) not null,
   primary key (AvtorID)
);

/*==============================================================*/
/* Table: Fakulteta                                             */
/*==============================================================*/
create table Fakulteta
(
   FakultetaID          int not null,
   NazivFakultete       varchar(1024) not null,
   primary key (FakultetaID)
);

/*==============================================================*/
/* Table: Gradivo                                               */
/*==============================================================*/
create table Gradivo
(
   GradivoID            int not null,
   OblikaID             int not null,
   Email                varchar(255) not null,
   ImeGradiva           varchar(1024) not null,
   Cena                 decimal not null,
   DatumNalozeno        date not null,
   Novo                 bool not null,
   primary key (GradivoID)
);

/*==============================================================*/
/* Table: JeAvtor                                               */
/*==============================================================*/
create table JeAvtor
(
   GradivoID            int not null,
   AvtorID              int not null,
   primary key (GradivoID, AvtorID)
);

/*==============================================================*/
/* Table: NaFakulteti                                           */
/*==============================================================*/
create table NaFakulteti
(
   GradivoID            int not null,
   FakultetaID          int not null,
   primary key (GradivoID, FakultetaID)
);

/*==============================================================*/
/* Table: Nakup                                                 */
/*==============================================================*/
create table Nakup
(
   Email                varchar(255) not null,
   GradivoID            int not null,
   CasNakupa            datetime not null,
   Popust               decimal not null,
   primary key (Email, GradivoID, CasNakupa)
);

/*==============================================================*/
/* Table: Oblika                                                */
/*==============================================================*/
create table Oblika
(
   OblikaID             int not null,
   Oblika               varchar(1024) not null,
   primary key (OblikaID)
);

/*==============================================================*/
/* Table: Predmet                                               */
/*==============================================================*/
create table Predmet
(
   PredmetID            int not null,
   ImePredmeta          varchar(1024) not null,
   primary key (PredmetID)
);

/*==============================================================*/
/* Table: PriPredmetu                                           */
/*==============================================================*/
create table PriPredmetu
(
   GradivoID            int not null,
   PredmetID            int not null,
   primary key (GradivoID, PredmetID)
);

/*==============================================================*/
/* Table: Profesor                                              */
/*==============================================================*/
create table Profesor
(
   ProfesorID           int not null,
   ImeProfesorja        varchar(1024) not null,
   PriimekProfesorja    varchar(1024) not null,
   primary key (ProfesorID)
);

/*==============================================================*/
/* Table: ProfesorZahteva                                       */
/*==============================================================*/
create table ProfesorZahteva
(
   GradivoID            int not null,
   ProfesorID           int not null,
   primary key (GradivoID, ProfesorID)
);

/*==============================================================*/
/* Table: Uporabnik                                             */
/*==============================================================*/
create table Uporabnik
(
   Email                varchar(255) not null,
   ImeUporabnika        varchar(1024) not null,
   DatumPrijave         date not null,
   HashGesla            varchar(1024) not null,
   primary key (Email)
);

alter table Gradivo add constraint FK_JeOblike foreign key (OblikaID)
      references Oblika (OblikaID) on delete restrict on update restrict;

alter table Gradivo add constraint FK_Prodaja foreign key (Email)
      references Uporabnik (Email) on delete restrict on update restrict;

alter table JeAvtor add constraint FK_JeAvtor foreign key (GradivoID)
      references Gradivo (GradivoID) on delete restrict on update restrict;

alter table JeAvtor add constraint FK_JeAvtor2 foreign key (AvtorID)
      references Avtor (AvtorID) on delete restrict on update restrict;

alter table NaFakulteti add constraint FK_NaFakulteti foreign key (GradivoID)
      references Gradivo (GradivoID) on delete restrict on update restrict;

alter table NaFakulteti add constraint FK_NaFakulteti2 foreign key (FakultetaID)
      references Fakulteta (FakultetaID) on delete restrict on update restrict;

alter table Nakup add constraint FK_JeKupljeno foreign key (GradivoID)
      references Gradivo (GradivoID) on delete restrict on update restrict;

alter table Nakup add constraint FK_Kupuje foreign key (Email)
      references Uporabnik (Email) on delete restrict on update restrict;

alter table PriPredmetu add constraint FK_PriPredmetu foreign key (GradivoID)
      references Gradivo (GradivoID) on delete restrict on update restrict;

alter table PriPredmetu add constraint FK_PriPredmetu2 foreign key (PredmetID)
      references Predmet (PredmetID) on delete restrict on update restrict;

alter table ProfesorZahteva add constraint FK_ProfesorZahteva foreign key (GradivoID)
      references Gradivo (GradivoID) on delete restrict on update restrict;

alter table ProfesorZahteva add constraint FK_ProfesorZahteva2 foreign key (ProfesorID)
      references Profesor (ProfesorID) on delete restrict on update restrict;

