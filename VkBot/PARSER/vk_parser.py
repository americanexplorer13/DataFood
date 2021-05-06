import vk_api
import re
import pandas as pd
import os
import threading
from sklearn.feature_extraction.text import TfidfVectorizer

liss = []
liss1 = []
vec = []
count = 0
vk_final = [109125816, 35469325, 70298501, 175494565, 97617794, 114639091, 188963404]

###################################################
# функция логина в ВК
###################################################

def login_in():
    vk_session = vk_api.VkApi('', '', auth_handler=auth_handler)  # ввод токена группы
    vk_session.auth()
    return vk_session.get_api()

###################################################
# функция поддержки хэндлера аутентификации
###################################################

def auth_handler():
    return input("Enter authentication code: "), True

###################################################
# функция парсинга
###################################################


def get_text_group(count):
    for z in group_get['items']:
            z['text'] = re.sub(r'\n', ' ', str(z['text']))
            z['text'] = re.sub(r'ё|Ё', 'е', str(z['text']))
            z['text'] = re.sub(r'\[(club|id)(.{1,20000})\|(.{1,20000})\]', ' ', str(z['text']))
            z['text'] = re.sub(r'[^ ]{1,20000}\.[^ ]{1,20000}\/?[^ ]{1,20000}', ' ', str(z['text']))
            z['text'] = re.sub(r'[^а-яА-Яa-zA-Z]', ' ', str(z['text']))
            z['text'] = re.sub(r'^ ', '', str(z['text']))
            z['text'] = re.sub(r' +', ' ', str(z['text']))
            z['text'] = re.sub(r' $', '', str(z['text']))
            liss.append(z['text'].lower())  # присоединяет распарсенный текст к списку
    print('THREAD-{} WAS ENDED'.format(count))


if __name__ == '__main__':

    vk = login_in()

    for i in vk_final:  # он берет все паблики юзера и удаляет те что в бан лист вошли
        count += 1
        try:
            group_get = vk.wall.get(owner_id=int(-i), count=50)  # пробует открыть 30 записей в паблике
        except vk_api.exceptions.ApiError:  # если не получается по какой-то причине...
            print('Public closed, go ahead!')  # дебаг функция, показывает закрыт ли паблик
            continue

        print("STARTED THREAD-{}".format(count))
        open_thread = threading.Thread(target=get_text_group, args=(count, ))  # вызывает основную функцию
        open_thread.start()
        vectorizer = TfidfVectorizer(liss)
        vec = vectorizer.fit_transform(liss).toarray()
        print(liss)
        # print(vec.shape)

        for i in range(384):
            print(vectorizer.get_feature_names()[i])
            liss1.append(vec[1])
            print(vec[1][i])

    # собирает датасет Pandas'а в соответствие с dataframe
    pd.DataFrame.from_dict({'txt': liss}).to_csv("DATASETS/TESTING/VK/vk_dataset.csv", index=False)
    pd.DataFrame.from_dict({'txt': liss1}).to_csv("DATASETS/TESTING/VK/parse_dataset.csv", index=False)
